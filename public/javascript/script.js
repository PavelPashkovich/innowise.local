// Delete confirmation
function delete_confirm(e) {
    if(confirm('Delete?')){
        return true;
    }else{
        e.preventDefault();
    }
}

// Checkbox select all on users page
$('#select-all').click(function () {

    // find "select-all" checkbox
    let $selectAll = $('#select-all');

    // find all checkboxes
    let $checkboxes = $('.chkbox');

    // find the button "delete_selected"
    let $deleteSelected = $('#delete_selected');

    // add prop "checked" as for checkbox #select-all
    $checkboxes.prop('checked', $(this).prop('checked'));

    // if "#select-all" is checked remove "disabled" prop from delete_selected button
    $deleteSelected.prop({'disabled': !$selectAll.prop('checked')});

    // if delete_selected button is disabled add class
    if ($deleteSelected.is(':disabled')){
        $deleteSelected.prop('class', 'btn btn-sm btn-outline-secondary m-1');
    } else {
        $deleteSelected.prop('class', 'btn btn-sm btn-outline-danger m-1');
    }

});

// Checkboxes on users page
$('.chkbox').click(function () {

    // find "select-all" checkbox
    let $selectAll = $('#select-all');

    // find all checkboxes
    let $checkboxes = $('.chkbox');

    // find all "checked" checkboxes
    let $checked = $checkboxes.filter(':checked');

    // find the button delete_selected
    let $deleteSelected = $('#delete_selected');

    // compare lengths of all checkboxes and "checked" checkboxes
    // if they are equal - add "checked" prop to #select-all
    // if they are not - remove "checked" prop from #select-all
    $selectAll.prop('checked', $checkboxes.length === $checked.length);

    // if there are no "checked" checkboxes delete_selected button is disabled
    $deleteSelected.prop({'disabled': !$checked.length});

    // if delete_selected button is disabled add class
    if ($deleteSelected.is(':disabled')){
        $deleteSelected.prop('class', 'btn btn-sm btn-outline-secondary m-1');
    } else {
        $deleteSelected.prop('class', 'btn btn-sm btn-outline-danger m-1');
    }

});