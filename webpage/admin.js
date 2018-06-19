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
            console.log(result);
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
            console.log(result);
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
            console.log(result);
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
            console.log(result);
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
            console.log(result);
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
            console.log(result);
        }});
    }
}