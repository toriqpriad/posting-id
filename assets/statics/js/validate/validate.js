// input = data , name = name to alert
function empty_validate(input,name){
    if(input == ""){
      create_toastr("warning", name + " tidak boleh kosong "); 
      throw new Error('lengkapi data');
    }
  }
