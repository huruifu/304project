import requests
import datetime
from bs4 import BeautifulSoup

TEAM_INSERT_TEMPLATE = "INSERT INTO TEAM VALUES " \
                       "('{name}', '{city}', {wins}, {losses});\n"
PLAYER_INSERT_TEMPLATE = "INSERT INTO PLAYERHAS VALUES " \
                         "('{name}', '{nationality}', {age}, {jersey_number}, '{team}');\n"
GAME_INSERT_TEMPLATE = "INSERT INTO GAMEPLAY VALUES (" \
                       "'{home_team}', '{away_team}', '{game_time}', '{game_location}', " \
                       "{home_team_score}, {away_team_score});\n"
COACH_INSERT_TEMPLATE = "INSERT INTO COACH VALUES " \
                        "('{name}', '{college}', '{is_assistant}', '{team}', {wins}, {losses});\n"
CAREER_INSERT_TEMPLATE = "INSERT INTO CAREER VALUES " \
                         "('{name}', {mvp_num}, {all_star_num}, '{draft}');\n"
ATTENDS_INSERT_TEMPLATE = "INSERT INTO ATTENDS VALUES " \
                          "('{name}', '{game_time}', '{game_location}', " \
                          "{points}, {rebounds}, {assists}, {blocks}, {steals});\n"
FAV_TEAM_INSERT_TEMPLATE = "INSERT INTO USER_LIKETEAM VALUES" \
                           "('{user_id}', '{team_name}');\n"
FAV_PLAYER_INSERT_TEMPLATE = "INSERT INTO USER_LIKEPLAYER VALUES" \
                             "('{user_id}', '{player_name}');\n"
NBA_API_TEMPLATE_URL = "http://data.nba.net/10s/{}"

data = {
    'teams': {},
    'players': {},
    'games': [],
    'coaches': []
}

insert_statements = []


def calculate_age(dob):
    b_year, b_month, b_day = dob.split("-")
    b_year, b_month, b_day = int(b_year), int(b_month), int(b_day)
    now = datetime.datetime.utcnow()
    age = now.year - b_year
    if now.month < b_month:
        age = age - 1
    elif now.month == b_month and b_day > now.day:
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
            'jersey_number': player['jersey'],
            'nationality': player['country'],
            'mvp_num': 0,
            'all_star_num': 0
        }

# MVP #
html = requests.get('https://www.basketball-reference.com/awards/mvp.html').text
html_parser = BeautifulSoup(html, 'html.parser')
for row in html_parser.select("#mvp_summary tbody tr"):
    name = row.find(attrs={'data-stat': 'player'}).find('a').string
    for player_id, player in data['players'].iteritems():
        if name == player['name']:
            player['mvp_num'] = int(row.find(attrs={'data-stat': 'counter'}).string)
# ALL-STAR APPEARANCES
html = requests.get('https://www.basketball-reference.com/awards/all_star_by_player.html').text
html_parser = BeautifulSoup(html, 'html.parser')
for row in html_parser.select("#div_all_star_by_player tbody tr"):
    name = row.find('a').string
    for player_id, player in data['players'].iteritems():
        if name == player['name']:
            player['all_star_num'] = int(row.select(".center")[0].string)


for game in requests.get(NBA_API_TEMPLATE_URL.format("/prod/v1/2017/schedule.json")).json()['league']['standard']:
    home_team = game['hTeam']
    away_team = game['vTeam']
    game_id = game['gameId']
    game_date = game['startDateEastern']
    if "2017" in game['startTimeUTC'] \
            and home_team['teamId'] in data['teams'] \
            and away_team['teamId'] in data['teams']\
            and game_date < "20171101": # one month of data
        game_time = game['startTimeUTC'].replace('T', ' ')[:-5]
        game_location = data['teams'][home_team['teamId']]['city']
        data['games'].append({
            'home_team': data['teams'][home_team['teamId']]['name'],
            'away_team': data['teams'][away_team['teamId']]['name'],
            'home_team_score': home_team['score'],
            'away_team_score': away_team['score'],
            'game_time': game_time,
            'game_location': game_location
        })
        # update wins/losses for team
        if home_team['score'] > away_team['score']:
            data['teams'][home_team['teamId']]['wins'] += 1
            data['teams'][away_team['teamId']]['losses'] += 1
        else:
            data['teams'][away_team['teamId']]['wins'] += 1
            data['teams'][home_team['teamId']]['losses'] += 1

        url = '/prod/v1/{}/{}_boxscore.json'.format(game['startDateEastern'], game['gameId'])
        resp = requests.get(NBA_API_TEMPLATE_URL.format(url))
        if resp.status_code == 200:
            for game_player in resp.json()['stats']['activePlayers']:
                if game_player['personId'] in data['players']:
                    player = data['players'][game_player['personId']]
                    stats = {
                        'name': player['name'],
                        'game_time': game_time,
                        'game_location': game_location,
                        'points': game_player['points'],
                        'rebounds': game_player['totReb'],
                        'assists': game_player['assists'],
                        'blocks': game_player['blocks'],
                        'steals': game_player['steals']
                    }
                    if 'stats' in player:
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
        'is_assistant': 'Y' if coach['isAssistant'] else 'N',
        'college': coach['college'].replace("'", "''"),
        'wins': data['teams'][coach['teamId']]['wins'],
        'losses': data['teams'][coach['teamId']]['losses'],
        # TODO: age, wasPlayerBefore
    })

with open('populate_tables.sql', 'w') as f:
    f.write("INSERT INTO Users VALUES ('admin_user', 'Y', 'password');\n" 
            "INSERT INTO Users VALUES ('normal_user', 'N', 'password');\n")

    for team in data['teams'].values()[:5]:
        f.write(FAV_TEAM_INSERT_TEMPLATE.format(
            user_id='normal_user',
            team_name=team['name']
        ))

    for player in data['players'].values()[:5]:
        f.write(FAV_PLAYER_INSERT_TEMPLATE.format(
            user_id='normal_user',
            player_name=player['name']
        ))

    for teamId, team in data['teams'].iteritems():
        f.write(TEAM_INSERT_TEMPLATE.format(**team))

    for game in data['games']:
        f.write(GAME_INSERT_TEMPLATE.format(**game))

    for coach in data['coaches']:
        f.write(COACH_INSERT_TEMPLATE.format(**coach))

    for playerId, player in data['players'].iteritems():
        f.write(PLAYER_INSERT_TEMPLATE.format(**player))
        f.write(CAREER_INSERT_TEMPLATE.format(**player))
        if 'stats' in player:
            for stat in player['stats']:
                f.write(ATTENDS_INSERT_TEMPLATE.format(**stat))
