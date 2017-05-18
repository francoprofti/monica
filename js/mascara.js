function mascara(o,f){
v_obj=o
v_fun=f
setTimeout("execmascara()",1)
}

function execmascara(){
v_obj.value=v_fun(v_obj.value)
}

function moeda(v){ 

v=v.replace(/\D/g,"") // permite digitar apenas numero 
v=v.replace(/(\d{0})(\d{1,2})$/,"$1,$2") // coloca virgula antes dos ultimos 4 digitos 
return v;
}











function numeros(o,f){
v_obj=o
v_fun=f
setTimeout("execmascaranum()",1)
}

function execmascaranum(){
v_obj.value=v_fun(v_obj.value)
}

function moedanum(v){ 

v=v.replace(/\D/g,"") // permite digitar apenas numero 

return v;
}

    