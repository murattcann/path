$(function(){
    const NOT_VERIFIED_STRING = "not_verified_string";
    const HAS_OPEN_BRACKETS = "has_open_brackets";
    const HAS_TOO_MANY_OPEN_BRACKETS = "has_too_many_open_brackets";
    $("#btnSubmit").on("click", function(){
        let stringVal = $("#param").val();
    
        $.ajax({
            url: "./php/operation.php",
            type: "POST",
            crossDomain: false,
            dataType: "JSON",
            data:{
                    stringVal: stringVal,
                    operation: "doTest",
            },
            success: function(response){
                if(response.status == 200){
                    alert("Başarılı");
                }  

                if(response.status == 400){
                    if(response.reason === NOT_VERIFIED_STRING){
                        alert("Hatalı Parametre");
                    }
                    if(response.reason === HAS_OPEN_BRACKETS){
                        alert("Başarısız");
                    }

                    if(response.reason === HAS_TOO_MANY_OPEN_BRACKETS) {
                        alert("Çok Fazla Kapanmamış Parantez Var");
                    }
                }
            }
        });
    })
});