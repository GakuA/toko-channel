var shori = "";

function tabClick(tabTo){
    if(shori == ""){
        shori = "yes";

        if(tabTo == "select"){
            $.when(
                $.ajax({
                    url: "tag.php",
                    success: function(thumbnailAjax) {
                        $("#thumbnail").html(thumbnailAjax);
                    }
                })
            ).done(function() {
                $.ajax({
                    type: "POST",
                    url: "tab.php",
                    data: 'titleAjax=' + tabTo,
                    success: function(tabAjax) {
                        $("#tab").html(tabAjax);
                    }
                });
            });
        }else{
            $.when(
                $.ajax({
                    type: "POST",
                    url: "thumbnail.php",
                    data: 'titleAjax=' + tabTo,
                    success: function(thumbnailAjax) {
                        $("#thumbnail").html(thumbnailAjax);
                    }
                })
            ).done(function() {
                $.ajax({
                    type: "POST",
                    url: "tab.php",
                    data: 'titleAjax=' + tabTo,
                    success: function(tabAjax) {
                        $("#tab").html(tabAjax);
                    }
                });
            });
        }
        shori = "";
    }
}

function closeTab(tabNo, tab){

    if(tab == "select"){
        $.ajax({
            type: "POST",
            url: "close.php",
            data: "tab=" + tabNo,
            success: function(tabAjax) {
                $("#tab").html(tabAjax);
            }
        });
    }else{
        $.when(
            $.ajax({
                type: "POST",
                url: "thumbnail.php",
                data: "tab=" + tabNo,
                success: function(thumbnailAjax) {
                    $("#thumbnail").html(thumbnailAjax);
                }
            })
        ).done(function() {
            $.ajax({
                type: "POST",
                url: "close.php",
                data: "tab=" + tabNo,
                success: function(tabAjax) {
                    $("#tab").html(tabAjax);
                }
            });
        });
    }
}

function selectEmo(){
    var flag = "f";
    var i = 0;
    var arrEmo = [];
    
    while(i < 14){
        if(document.tag.elements[i].checked){
            flag = "t";
            arrEmo.push(i);
        }
        i = parseInt(i) + 1;
    }

    if(flag == "f"){
        window.alert("感情を選んでね！");
        return false;
    }else{
        $.ajax({
            type: "POST",
            url: "fromTag.php",
            data: "emo=" + arrEmo,
            success: function(selectAjax) {
                tabClick(selectAjax);
            }
        });
    }
}
