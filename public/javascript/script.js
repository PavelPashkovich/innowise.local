function delete_confirm(e) {
    if(confirm('Delete?')){
        return true;
    }else{
        e.preventDefault();
    }
}