$(document).ready(function(){
    console.log('readyyyy');
    showTeams();
});

let teamInitialized, playerInitialized, gameInitialized = false;


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
} 

function onSelectTab(name){
    let tabs = ['team', 'game', 'player'];
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




// const renderPlayer = () => {
//     showPlayers();
// }

// const renderGame = () => {
//     showGames();
// }

// $(document).ready(
//     showTeams()
// );