    function showButtons() {
        var buttonCardShow = document.getElementById("sourceButtons");
        buttonCardShow.style.display = "block";
    }
        
     function changeColor(id) {
         const root = document.documentElement;
         var btnToCol = document.getElementById(id); 
         
         showIsolations(id);
         
         if (btnToCol.style.color == 'white') {
             setColor(btnToCol, 'lightgray', 'black');
         } else {
             setColor(btnToCol, 'green', 'white');
         };         
     }

    function setColor(element, bgcolor, txtColor) {
            element.style.backgroundColor = bgcolor;
            element.style.color = txtColor;
    }
        
        
    function showIsolations(id) {
        
        var conCatCard = id + "-card";
        var card = document.getElementById(conCatCard);
        
        if (card.style.display === "block") {
             card.style.display = "none";
         } else {
             card.style.display = "block";
         };
    }


    function launchAF(title, content) {
        console.log('Asset Found Modal launched');
        $("#assetFound .modal-title").text(title);
        $("#assetFound .modal-body").text(content);
        $("#assetFound").modal("show");
    }
    
    function launchNF(title, content) {
        console.log('Not found Modal launched');
        $('#notFound .modal-title').text(title);
        $('#notFound .modal-body').text(content);
        $('#notFound').modal('show');
    }

    function launchAI(title, content) {
        console.log('Already Isolated Modal launched');
        $('#alreadyIsod .modal-title').text(title);
        $('#alreadyIsod .modal-body').text(content);
        $('#alreadyIsod').modal('show');
    }

 
        




       