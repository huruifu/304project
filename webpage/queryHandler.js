function handleQuery(id){
    const inputs = document.getElementById(id).getElementsByTagName('input');
    console.log('handled');
    let params = ['a','b','c'];
    // for(i = 0; i<inputs.size(); i++){
    //     params[i] = inputs[i].value();
    // };
    $.ajax({
        url: "test.php",
        type:'POST',
        data: {
            id,
            params,
        },
        dataType: 'json',
        success: function(result){
            console.log('afhwkfaw');
        $("#team_result").html("<b>id: </b>"+result+"<b> : </b>");
    }});
}

function showTeams(){
    $.ajax({
        url: "../model/player.php",
        type:'POST',
        data: {
            team: '',
        },
        dataType: 'json',
        success: function(result){
            console.log('afhwkfaw');
        $("#team_result").html("<ul>"+
        "<li>LA Lakers</li>"+
        "<li>Raptors</li>"+
        "<li>whatever</li>"+
      "</ul>");
    }});
}

function showPlayers(){
    $.ajax({
        url: "test.php",
        type:'POST',
        data: {
            player:'',
        },
        dataType: 'json',
        success: function(result){
            console.log('playerererere');
        $("#player_result").html("<ul>"+
        "<li>Stephen Curry</li>"+
        "<li>Kobe Bryant</li>"+
        "<li>Chris Paul</li>"+
      "</ul>");
    }});
}

function showGames(){
    $.ajax({
        url: "test.php",
        type:'POST',
        data: {
            game:'',
        },
        dataType: 'json',
        success: function(result){
            console.log('afhwkfaw');
        $("#team_q1_result").html("<b>id: </b>"+result+"<b> : </b>");
    }});
}

