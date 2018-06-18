function handleQuery(id){
    const inputs = document.getElementById(id).getElementsByTagName('input');
    console.log('handledddd');
    let params = [];
    for(i = 0; i<inputs.length; i++){
        params[i] = inputs[i].value;
    };
    console.log(params);
    $.ajax({
        url: "../query/queryHandler.php",
        type:'POST',
        data: {
            test: '',
            params,
        },
        success: function(result){
        console.log(result);
        $("#team_result").append(result);
    }});
}

function showTeams(){
    $.ajax({
        url: "../query/queryHandler.php",
        type:'POST',
        data: {
            id: 'team',
            params:[],
        },
        success: function(result){
        console.log(result);
        $("#team_result").append(result);
    }});
}

function showPlayers(){
    $.ajax({
        url: "../query/queryHandler.php",
        type:'POST',
        data: {
            id: 'player',
            params:[],
        },
        success: function(result){
        console.log(result);
        $("#player_result").append(result);
    }});
}

function showGames(){
    $.ajax({
        url: "../query/queryHandler.php",
        type:'POST',
        data: {
            id: 'game',
            params:[],
        },
        success: function(result){
        console.log(result);
        $("#game_result").append(result);
    }});
}

