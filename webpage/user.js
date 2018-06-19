$(document).ready(function(){
    console.log('readyyyy');
    $("#" + 'game').children().hide();
    $("#" + 'player').children().hide();
    $("#" + 'coach').children().hide();
    $("#" + 'user').children().hide();
    showTeams();
    teamInitialized = true;
});

let teamInitialized, playerInitialized, gameInitialized, userInitialized, coachInitialized = false;


const renderTab=(tabName) => {
    if(tabName == 'team' && !teamInitialized){
        showTeams();
        teamInitialized = true;
    }
    if(tabName == 'player' && !playerInitialized){
        showPlayers();
        playerInitialized = true;
    }
    if(tabName == 'game' && !gameInitialized){
        showGames();
        gameInitialized = true;
    }
    if(tabName == 'coach' && !coachInitialized){
        showCoaches();
        coachInitialized = true;
    }
    if(tabName == 'user' && !userInitialized){
        showUsers();
        userInitialized = true;
    }
} 

function onSelectTab(name){
    let tabs = ['team', 'game', 'player', 'user', 'coach'];
    tabs.forEach(tab =>{
        if(name === tab) {
            // $(document).ready(function(){
            //     console.log('ready');
            // });

            renderTab(tab);
            $("#" + tab).children().show();
            console.log(tab);
        }else{
            $("#"+ tab).children().hide();
        }
    });
};
