import requests
import datetime

TEAM_INSERT_TEMPLATE = "INSERT INTO TEAM VALUES " \
                       "('{name}', '{city}', {wins}, {losses});\n"
PLAYER_INSERT_TEMPLATE = "INSERT INTO PLAYERHAS VALUES " \
                         "('{name}', '{nationality}', {age}, {jersey_num}, '{team_name}');\n"
GAME_INSERT_TEMPLATE = "INSERT INTO GAMEPLAY VALUES (" \
                       "'{homeTeam}', '{awayTeam}', '{gameTime}', '{gameLocation}', " \
                       "{homeTeamScore}, {awayTeamScore});\n"
COACH_INSERT_TEMPLATE = "INSERT INTO COACH VALUES " \
                        "('{name}', '{college}', '{isAssistant}', '{team}', {wins}, {losses});\n"
CAREER_INSERT_TEMPLATE = "INSERT INTO CAREER VALUES " \
                         "('{name}', {mvp_num}, {all_star_num}, '{draft}');\n"
ATTENDS_INSERT_TEMPLATE = "INSERT INTO ATTENDS VALUES " \
                          "('{name}', '{game_time}', '{game_location}', " \
                          "{points}, {rebounds}, {assists}, {blocks}, {steals});\n"
NBA_API_TEMPLATE_URL = "http://data.nba.net/10s/{}"

data = {
    'teams': {},
    'players': {},
    'games': [],
    'coaches': []
}

insert_statements = []


def calculate_age(dob):
    byear, bmonth, bday = dob.split("-")
    byear, bmonth, bday = int(byear), int(bmonth), int(bday)
    now = datetime.datetime.utcnow()
    age = now.year - byear
    if now.month < bmonth:
        age = age - 1
    elif now.month == bmonth and bday > now.day:
        age = age - 1
    return age


for team in requests.get(NBA_API_TEMPLATE_URL.format("/prod/v1/2017/teams.json")).json()['league']['standard']:
    if team['isNBAFranchise']:
        data['teams'][team['teamId']] = {
            'name': team['fullName'],
            'city': team['city'],
            'wins': 0,
            'losses': 0
        }

for player in requests.get(NBA_API_TEMPLATE_URL.format("/prod/v1/2017/players.json")).json()['league']['standard']:
    if player['isActive'] \
            and player['teams'] \
            and player['nbaDebutYear'] is not "" \
            and player['teams'][-1]['seasonEnd'] == "2017" \
            and player['teams'][-1]['teamId'] in data['teams']:
        draft = player['draft']
        draft = "{}/{}/{}".format(draft['seasonYear'], draft['roundNum'], draft['pickNum'])
        if draft == "//":
            # draft is a primary key
            continue
        data['players'][player['personId']] = {
            'name': (player['firstName'] + " " + player['lastName']).replace("'", "''"),
            'team': data['teams'][player['teams'][-1]['teamId']]['name'],
            'draft': draft,
            'age': calculate_age(player['dateOfBirthUTC']),
            'jerseyNumber': player['jersey'],
            'country': player['country'],
            'mvpNum': 0,
            'allStarNum': 0
            # TODO: mvp_num, all_star_num
            # https://www.basketball-reference.com/awards/mvp.html
            # https://www.basketball-reference.com/awards/all_star_by_player.html
        }

for game in requests.get(NBA_API_TEMPLATE_URL.format("/prod/v1/2017/schedule.json")).json()['league']['standard']:
    homeTeam = game['hTeam']
    awayTeam = game['vTeam']
    if "2017" in game['startTimeUTC'] \
            and homeTeam['teamId'] in data['teams'] \
            and awayTeam['teamId'] in data['teams']:
        gameTime = game['startTimeUTC'].replace('T', ' ')[:-5]
        gameLocation = data['teams'][homeTeam['teamId']]['city']
        data['games'].append({
            'homeTeam': data['teams'][homeTeam['teamId']]['name'],
            'awayTeam': data['teams'][awayTeam['teamId']]['name'],
            'homeTeamScore': homeTeam['score'],
            'awayTeamScore': awayTeam['score'],
            'gameTime': gameTime,
            'gameLocation': gameLocation
        })
        # update wins/losses for team
        if homeTeam['score'] > awayTeam['score']:
            data['teams'][homeTeam['teamId']]['wins'] += 1
            data['teams'][awayTeam['teamId']]['losses'] += 1
        else:
            data['teams'][awayTeam['teamId']]['wins'] += 1
            data['teams'][homeTeam['teamId']]['losses'] += 1

        gameId = game['gameId']
        gameDate = game['startDateEastern']
        if gameDate >= "20171101":
            continue
        url = "/prod/v1/{}/{}_boxscore.json".format(game['startDateEastern'], game['gameId'])
        resp = requests.get(NBA_API_TEMPLATE_URL.format(url))
        if resp.status_code == 200:
            for game_player in resp.json()['stats']['activePlayers']:
                if game_player['personId'] in data['players']:
                    player = data['players'][game_player['personId']]
                    stats = {
                        'gameTime': gameTime,
                        'gameLocation': gameLocation,
                        'points': game_player['points'],
                        'rebounds': game_player['totReb'],
                        'assists': game_player['assists'],
                        'blocks': game_player['blocks'],
                        'steals': game_player['steals']
                    }
                    if "stats" in player:
                        player['stats'].append(stats)
                    else:
                        player['stats'] = [stats]
        else:
            print(NBA_API_TEMPLATE_URL.format(url))
            print(resp.status_code)

for coach in requests.get(NBA_API_TEMPLATE_URL.format("/prod/v1/2017/coaches.json")).json()['league']['standard']:
    data['coaches'].append({
        'name': (coach['firstName'] + " " + coach['lastName']).replace("'", "''"),
        'team': data['teams'][coach['teamId']]['name'],
        'isAssistant': 'Y' if coach['isAssistant'] else 'N',
        'college': coach['college'].replace("'", "''"),
        'wins': data['teams'][coach['teamId']]['wins'],
        'losses': data['teams'][coach['teamId']]['losses'],
        # TODO: age, wasPlayerBefore
    })

with open('populate_tables.sql', 'w') as f:
    f.write("INSERT INTO Users VALUES ('admin_user', 'Y', 'password');\n" 
            "INSERT INTO Users VALUES ('normal_user', 'N', 'password');\n")
    for teamId, team in data['teams'].iteritems():
        f.write(TEAM_INSERT_TEMPLATE.format(
            name=team['name'],
            city=team['city'],
            wins=team['wins'],
            losses=team['losses']))

    for game in data['games']:
        f.write(GAME_INSERT_TEMPLATE.format(**game))

    for coach in data['coaches']:
        f.write(COACH_INSERT_TEMPLATE.format(**coach))

    for playerId, player in data['players'].iteritems():
        f.write(PLAYER_INSERT_TEMPLATE.format(
            name=player['name'],
            nationality=player['country'],
            age=player['age'],
            jersey_num=player['jerseyNumber'],
            team_name=player['team']
        ))
        f.write(CAREER_INSERT_TEMPLATE.format(
            name=player['name'],
            mvp_num=player['mvpNum'],
            all_star_num=player['allStarNum'],
            draft=player['draft']
        ))
        if 'stats' in player:
            for stat in player['stats']:
                f.write(ATTENDS_INSERT_TEMPLATE.format(
                    name=player['name'],
                    game_time=stat['gameTime'],
                    game_location=stat['gameLocation'],
                    points=stat['points'],
                    assists=stat['assists'],
                    rebounds=stat['rebounds'],
                    steals=stat['steals'],
                    blocks=stat['blocks']
                ))
