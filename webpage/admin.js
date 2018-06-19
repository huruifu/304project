$(document).ready(function(){
    console.log('readyyyy');
    $("#" + 'insert').children().hide();
    $("#" + 'delete').children().hide();
});


function onSelectTab(name){
    let tabs = ['update', 'insert', 'delete'];
    tabs.forEach(tab =>{
        if(name === tab) {
            $("#" + tab).children().show();
            console.log(tab);
        }else{
            $("#"+ tab).children().hide();
        }
    });
};


function handleQuery(id){
    const inputs = document.getElementById(id).getElementsByTagName('input');
    let params = [];
    for(i = 0; i<inputs.length; i++){
        params[i] = inputs[i].value;
    };
    console.log(params);
    if(id == 'coach_update'){
        console.log('updateeee');
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
            $("#update_result").empty(); 
            console.log(result);
            $("#update_result").append(result);

        },
        error: function(xhr, error){
            $("update_result").append(result);
        }});
    }
    if(id == 'coach_insert'){
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
            $("#insert_result").empty(); 
            console.log(result);
            $("#insert_result").append(result);
        },
        error: function(xhr, error){
            $("insert_result").append(result);
        }});
    }
    if(id == 'coach_delete'){
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
                $.ajax({
                    url: "queryHandler.php",
                    type:'POST',
                    data: {
                        id: 'coach',
                        params:[],
                    },
                    success: function(result){
                    console.log(result);
                    $("#delete_result").append(result);
                }})    
            $("#delete_result").empty(); 
            console.log(result);
            $("#delete_result").append(result);
        },
        error: function(xhr, error){
            $("delete_result").append(result);
        }});
    }
    if(id == 'team_update'){
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
            $("#update_result").empty(); 
            console.log(result);
            $("#update_result").append(result);
        },
    error: function(xhr, error){
            $("update_result").append(result);
        }});
    }
    if(id == 'team_insert'){
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
            $("#insert_result").empty(); 
            console.log(result);
            $("#insert_result").append(result);
        },
        error: function(xhr, error){
            $("insert_result").append(result);
        }});
    }
    if(id == 'team_delete'){
        $.ajax({
            url: "queryHandler.php",
            type:'POST',
            data: {
                id,
                params,
            },
            success: function(result){
            $("#delete_result").empty(); 
            console.log(result);
            $("#delete_result").append(result);
            $.ajax({
                url: "queryHandler.php",
                type:'POST',
                data: {
                    id: 'team',
                    params:[],
                },
                success: function(result){
                console.log(result);
                $("#delete_result").append(result);
            }});
        },
        error: function(xhr, error){
            $("delete_result").append(result);
        }

    });

    }
}