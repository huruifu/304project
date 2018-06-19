function handleQuery(id){
    const inputs = document.getElementById(id).getElementsByTagName('input');
    console.log('handledddd');
    let params = [];
    for(i = 0; i<inputs.length; i++){
        params[i] = inputs[i].value;
    };
    console.log(id.indexOf('team'));

    if(id.indexOf('team') == 0){
        console.log('tessahkak');
        $("#team_result").empty();
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
            console.log(result);
            $("#team_result").append(result);
        }});
    };
    if(id.indexOf('game') == 0){
        $("#game_result").empty();
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
            console.log(result);
            $("#game_result").append(result);
        }});
    };
    if(id.indexOf('player') == 0){
        $("#player_result").empty();
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
            console.log(result);
            $("#player_result").append(result);
        }});
    };

    if(id.indexOf('user') == 0){
        $("#user_result").empty();
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
            console.log(result);
            $("#user_result").append(result);
        }});
    };

    if(id.indexOf('coach') == 0){
        $("#coach_result").empty();
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
            console.log(result);
            $("#coach_result").append(result);
        }});
    };
}

function showTeams(){
    $.ajax({
        url: "queryHandler.php",
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
        url: "queryHandler.php",
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
        url: "queryHandler.php",
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

function showUsers(){
    $.ajax({
        url: "queryHandler.php",
        type:'POST',
        data: {
            id: 'user',
            params:[],
        },
        success: function(result){
        console.log(result);
        $("#user_result").append(result);
    }});
}

function showCoaches(){
    $.ajax({
        url: "queryHandler.php",
        type:'POST',
        data: {
            id: 'coach',
            params:[],
        },
        success: function(result){
        console.log(result);
        $("#coach_result").append(result);
    }});
}

