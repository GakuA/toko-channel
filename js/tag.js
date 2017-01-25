function emo(){
    var i = 0;
    var emotion = "";
    
    while(i < 14){
        if(document.tag.elements[i].checked){
            emotion += document.tag.elements[i].id;
        }
        i = parseInt(i) + 1;
    }
    
    document.getElementById("str").textContent = emotion;
}
