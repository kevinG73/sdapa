$('#diplome2').hide();
function load_page1()
{
    $('#voir_num_carte').show();
    $('#carte_et').attr('required', true)


}
function load_page2()
{
    $('#voir_num_carte').hide();
    $('#carte_et').attr('required', false)

}
function destroy(){
    $('#destroy').load('destroy.php')
}

function autre(){
    $('#diplome1').toggle();
    $('#diplome2').toggle();
}

function testage(value) {
    dob = new Date(value);
    var today = new Date();
    var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
    if (age<9){
        $('#Vdatemin').show();
    }else {
        $('#Vdatemin').hide();
    }
}
