function _mobileNavigation(e) {
    $(".tcon").toggleClass("tcon-transform"),
    $(".navigation.-mobile").toggleClass("-on")
}
function _closeMenu(){
    $(".tcon-transform").removeClass("tcon-transform"),
    $(".-on").removeClass("-on"),
    $(".-reveal").removeClass("-reveal")    
}
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function soLetras(v){
    return v.replace(/\d/g,"") //Remove tudo o que não é Letra
}
// Autocomplete CEP
function limpa_formulário_cep() {
    $("#cep").val("");
    $("#rua").val("");
    $("#bairro").val("");
    $("#cidade").val("");
    $("#uf").val("");
}   
//Quando o campo cep perde o foco.
$("#cep").blur(function() {
    //Nova variável "cep" somente com dígitos.
    var cep = $(this).val().replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if ($(this).val() != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#rua").val("...");
            $("#bairro").val("...");
            $("#cidade").val("...");
            $("#uf").val("...");

            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#rua").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $("#uf").val(dados.uf);
                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    limpa_formulário_cep();
                    alert("CEP não encontrado.");
                }
            });
        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
}); 
$(document).ready(function () {
    $('.owl-carousel').owlCarousel({
        loop:true,
        center:false,
        autoWidth:false,
        autoplayHoverPause: true,
        autoplay:true,
        autoplayTimeout:7000,
        margin: 0,
        nav:true,
        dots:false,
        items: 1,
        navText:false,
        URLhashListener:true        
    });
    $( ".owl-carousel.-webdoor .owl-nav [class*='owl-']" ).wrapAll( "<div class='container' />");
    $(window).scroll(function(event){
        _closeMenu()
    }); 
    $(window).resize(function(){
        _closeMenu()
    });
    $(".login-form").validate({
        rules: {
            login: {
                required: true,
                normalizer: function(value) {
                    return $.trim(value);
                }
            },
            senha: {
                required: true
            }            
        },
        messages: {
            login: {
                required: "Campo obrigatorio."
            },
            senha: {
                required: "Campo obrigatorio."
            }            
        }
    });
    $('.telefone').mask('(99) 9999-9999');
    $('.celular').mask('(99) 9-9999-9999');
    $('.cpf').mask('999.999.999-99');
    $('.cep').mask('99.999-999');
});
    
