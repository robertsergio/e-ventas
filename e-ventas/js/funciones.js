/**
 * La variable baseUrl debe ser definida antes de usar estas funciones. 
 * 
 */
function cargarSubcategorias(){
	new Ajax.Updater ('subcategoria', baseUrl+'productos/ajaxFindSubcategoria', {method:'post', postBody:'categoria='+$F('categoria')});
	

}
function cargarBarrios(){
	new Ajax.Updater('barrio_id', baseUrl+'usuarios/ajaxFindBarrio', {method:'post', postBody:'ciudad='+$F('ciudad')});
	

}
function aviso_borrar(controlador,nombre, id){
    if(confirm("Esta seguro que desea BORRAR a \"" + nombre+"\"?"))
        document.location.href=baseUrl+controlador+"/borrar/"+id;
}

function cargar_supervisor() {
	supervisor=document.getElementById('supervisores');
	rol=document.getElementById('rol_id');
	if(rol.value!=3)
    {
    	supervisor.style.visibility ='hidden';
    }else
    	supervisor.style.visibility ='visible';
    	
	
}

function buscarCliente() {
	
	new Ajax.Updater('datos_cliente', baseUrl+'pedidos/ajaxFindCliente', {method:'post', postBody:'ci='+$F('cliente')});
	
}