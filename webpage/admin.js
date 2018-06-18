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

function updatePassword() {
    let username = $("#username").text();
    let password = $("#password").val();

    $.ajax({
        type: 'PUT',
        url: `../api/user.php?username=${username}&password=${password}`,
        success: function () {
            alert("Successfully updated password.")
        },
        error: function () {
            alert("Password could not be updated, please ensure it is at least 8 characters.")
        }
    });
}

function deleteAccount() {
    var username = $("#username").text();
    $.ajax({
        type: 'DELETE',
        url: `../api/user.php?username=${username}`,
        success: function () {
            window.location = "/webpage/login.php";
        },
        error: function () {
            alert("Failed to delete account.")
        }
    });
}

// const renderPlayer = () => {
//     showPlayers();
// }

// const renderGame = () => {
//     showGames();
// }

// $(document).ready(
//     showTeams()
// );