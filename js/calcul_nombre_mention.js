
function calcul(id) {
    var l1c1= $('#mention_l1_c1').val();
    var l1c2= $('#mention_l1_c2').val();
    var l1c3= $('#mention_l1_c3').val();

    var l2c1= $('#mention_l2_c1').val();
    var l2c2= $('#mention_l2_c2').val();
    var l2c3= $('#mention_l2_c3').val();

    var l3c1= $('#mention_l3_c1').val();
    var l3c2= $('#mention_l3_c2').val();
    var l3c3= $('#mention_l3_c3').val();


    var a = id.split('_');

    if (a[1]=='l1')
    {
        $('#div_'+a[1]+'_c4').load('loader/total1c4.php',
            {
                l1c1:l1c1,
                l1c2:l1c2,
                l1c3:l1c3
            });


    }

    if (a[1]=='l2')
    {
        $('#div_'+a[1]+'_c4').load('loader/total2c4.php',
            {
                l2c1:l2c1,
                l2c2:l2c2,
                l2c3:l2c3

            });
    }

    if (a[1]=='l3')
    {
        $('#div_'+a[1]+'_c4').load('loader/total3c4.php',
            {
                l3c1:l3c1,
                l3c2:l3c2,
                l3c3:l3c3

            });
    }




}

