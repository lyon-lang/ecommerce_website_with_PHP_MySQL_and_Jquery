<footer class="text-center" id="footer">&copy; <span id="showdate"></span> KuCWebMall
<script> 
var dateContainer = document.getElementById("showdate");
dateContainer.innerHTML = new Date().getFullYear();
</script>
</footer>

<script>

function detailsmodal(id){
	var data = {"id" : id};
	jQuery.ajax({
		url : '/online-mall/includes/detailsmodal.php',
		method : "post",
		data : data,
		success : function(data){
			jQuery('body').append(data);
			jQuery('#details-modal').modal('toggle');
		},
		error : function(){
			alert("something went wrong.");
		}

	});
}

function update_cart(mode,edit_id,edit_size){
	var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
	jQuery.ajax({
		url : '/online-mall/admin/parsers/update_cart.php',
		method : 'post',
		data : data,
		success: function(){
			location.reload();
		},
		error: function(){ 
			alert("something went wrong!");
			 }
	});

}

function add_to_cart(){
	jQuery('#modal_errors').html("");
	var size = jQuery('#size').val();
	var quantity = jQuery('#quantity').val();
	var available = jQuery('#available').val();
	var error = '';
	var data = jQuery('#add_product_form').serialize();
	if(size == '' || quantity == '' || quantity == 0){
		error += '<p class="text-danger text-center">You must choose a size and quantity</p>';
		jQuery('#modal_errors').html(error);
		return;
	}else if(quantity > available){
		error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
		jQuery('#modal_errors').html(error);
		return;
	}else{
		jQuery.ajax({
			url: '/online-mall/admin/parsers/add_cart.php',
			method: 'post',
			data: data,
			success: function(){
				location.reload();
			},
			error: function(){
			 alert("something went wrong"); 
			}
		});
	}
}

</script>

</body>

</html>
