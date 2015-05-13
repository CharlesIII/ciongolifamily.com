<?php
        require_once('includes/top.php');
?>
        <title>Mealmaster abbreviations</title>
        <meta name="description" content="Abbreviations used in Mealmaster format exports.">
		<script src="js/my.back.from.info.js"></script>
		
</head>
<body>
        <div class='ok message_box' style="display:none;"></div>
        <?php
		@set_time_limit(36000);
                require_once('includes/banner.php');
		if (isset($status)) {
			if ($status=='suspended') {
				echo "<script type='text/javascript'>
                    $('.message_box').removeClass('ok');
                    $('.message_box').html('<img class=\'close_message\'  src=\'images/ok.png\' >$susmsg');
                    $('.message_box').show();
                </script>";
			}
		}
        ?>
        <div id="sb-site" class="sb-slide">
                <div class=container>
                    <div class="row">
                        <!-- content start -->
                        <div class="col-xs-12 col-sm-12">
				            <h3><strong>Mealmaster Abbreviations </strong>used in exports</h3>
				            <br>
				            <INPUT type=button class='back btn' value='Back To Export'>
				            <br><br>
				            <strong>Mealmaster Notes:</strong>
				            <p>Mealmaster format requires units of measure to be restricted to no more than 2 letters. So here is a list of the abbreviation used by Web Recipe Manager when exporting recipes in this format.</p>
				            <div>
                                <div class=dib>
                                    bb    bulb<br>
                                    bc    branch<br>
                                    bg    bag<br>
                                    bk    block<br>
                                    bk    jar(swedish)<br>
                                    bl    ball<br>
                                    bl    sheet(afrikaans)<br>
                                    bn    bunch<br>
                                    br    bar<br>
                                    bs    basket<br>
                                    bt    bottle<br>
                                    bx    box<br>
                                    c    cup<br>
                                    cb    cube<br>
                                    cc    milliliter<br>
                                    cf    capful<br>
                                    cg    centigram<br>
                                    cl    centiliter<br>
                                    cm    centimeter<br>
                                    cn    can<br>
                                    co    container<br>
                                    cs    pinch(hungarian)<br>
                                    ct    carton<br>
                                    cv    clove<br>
                                    d    dessertspoon<br>
                                    dg    decigram<br>
                                    dl    deciliter<br>
                                    dr    drop<br>
                                    ds    dash<br>
                                    dz    dozen<br>   
                                </div>
                                <div class=dib>
                                    ea    each<br>    
                                    ek    tablespoon(hungarian)<br>    
                                    el    tablespoon(dutch)<br>    
                                    en    envelope<br>    
                                    er    ear<br>    
                                    fl    fluid ounce<br>    
                                    ft    fillet<br>    
                                    fv    flavour<br>    
                                    g    gram<br>    
                                    ga    gallon<br>    
                                    gl    glass<br>    
                                    gn    grain<br>    
                                    gr    clove(hungarian)<br>    
                                    gs    generous sprinkle<br>    
                                    hc    heaped cup<br>    
                                    hd    head<br>    
                                    hD    heaped dessertspoon<br>    
                                    hf    handful<br>    
                                    hT    heaped tablespoon<br>    
                                    ht    heaped teaspoon<br>    
                                    in    inch<br>    
                                    jr    jar<br>    
                                    kb    knob<br>    
                                    kg    kilogram<br>    
                                    l    litre<br>    
                                    lB    large bunch<br>    
                                    lb    pound<br>    
                                    lc    large can<br>    
                                    lC    large clove<br>    
                                    le    bunch(romanian)<br>    
                                </div>
                                <div class=dib>
                                    lf    leaf<br>
                                    lg    large<br>
                                    lh    large handful<br>
                                    lH    large head<br>
                                    ln    spoon<br>
                                    lp    large pinch<br>
                                    lt    teaspoon(romanian)<br>
                                    lv    loaf<br>
                                    md    medium<br>
                                    mg    milligram<br>
                                    mH    medium head<br>
                                    mk    NULL<br>
                                    ml    milliliter<br>
                                    nf    deciliter(hungarian)<br>
                                    oz    ounce<br>
                                    pc    piece<br>
                                    pk    package<br>
                                    pn    pinch<br>
                                    pr    portion<br>
                                    pT    part<br>
                                    pt    pint<br>
                                    pu    punnet<br>
                                    qt    quart<br>
                                    rb    rib<br>
                                    RC    recipe<br>
                                    rc    rounded cup<br>
                                    rd    rounded dessertspoon<br>
                                    rk    rack<br>
                                    rl    roll<br>
                                    rs    rasher<br>
                                </div>
                                <div class=dib>
                                    rT    rounded tablespoon<br>
                                    rt    rounded teaspoon<br>
                                    sb    slab<br>
                                    sB    small bunch<br>
                                    sc    small can<br>
                                    se    shake<br>
                                    sh    sheet<br>
                                    SH    shot<br>
                                    sH    small handful<br>
                                    sk    slice(swedish)<br>
                                    sk    stalk<br>
                                    sl    slice<br>
                                    sm    small<br>
                                    sp    sprig<br>
                                    sq    square<br>
                                    sr    strip<br>
                                    ss    splash<br>
                                    st    stick<br>
                                    sv    sleeve<br>
                                    tb    tablespoon<br>
                                    th    small head<br>
                                    tk    teaspoon(hungarian)<br>
                                    tl    teaspoon(dutch)<br>
                                    tn    tin<br>
                                    ts    teaspoon<br>
                                    tu    tube<br>
                                    un    unit<br>
                                    wh    whole<br>
                                    xl    extra large<br>
                                </div>
                            </div>
				            
				            <br><br>
				            <INPUT type=button class='back btn' value='Back To Export'>
				            <INPUT type=hidden id=client value='<?php echo $client ?>'>
			            </div>
                            <?php
                                    require_once('includes/bottom.php');
                            ?>
                