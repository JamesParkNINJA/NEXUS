<?php 
    $absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
    $wp_load = $absolute_path[0] . 'wp-load.php';
    require_once($wp_load);
    include(nexus_plugin_inc('nexus_api/data/nexus_options.php')); // Nexus Overall Options

    $nexusModeList = get_option('nexus_mode_list');
    $nexusThemeColors = $nexus_THEMESETTINGS['nexus_theme_colors'];
        $tbs = ($nexusThemeColors['tbs'] ? $nexusThemeColors['tbs'] : '#');
            $tbsDARK = nexus_colourBrightness($tbs, -0.2);
            $tbsLIGHT = nexus_colourBrightness($tbs, 0.1);
            $tbsText = (nexus_lumos($tbs) == 'light' ? $tbsDARK : $tbsLIGHT);
        $ass = $nexusThemeColors['ass'];
            $assDARK = nexus_colourBrightness($ass, -0.2);
            $assLIGHT = nexus_colourBrightness($ass, 0.1);
            $assText = (nexus_lumos($ass) == 'light' ? $assDARK : $assLIGHT);
        $pro = $nexusThemeColors['pro'];
            $proDARK = nexus_colourBrightness($pro, -0.2);
            $proLIGHT = nexus_colourBrightness($pro, 0.1);
            $proText = (nexus_lumos($pro) == 'light' ? $proDARK : $proLIGHT);
        $rej = $nexusThemeColors['rej'];
            $rejDARK = nexus_colourBrightness($rej, -0.2);
            $rejLIGHT = nexus_colourBrightness($rej, 0.1);
            $rejText = (nexus_lumos($rej) == 'light' ? $rejDARK : $rejLIGHT);
        $sig = $nexusThemeColors['sig'];
            $sigDARK = nexus_colourBrightness($sig, -0.2);
            $sigLIGHT = nexus_colourBrightness($sig, 0.1);
            $sigText = (nexus_lumos($sig) == 'light' ? $sigDARK : $sigLIGHT);
        $high = $nexusThemeColors['high'];
            $highDARK = nexus_colourBrightness($high, -0.2);
            $highLIGHT = nexus_colourBrightness($high, 0.1);
            $highText = (nexus_lumos($high) == 'light' ? $highDARK : $highLIGHT);
        $com = $nexusThemeColors['com'];
            $comDARK = nexus_colourBrightness($com, -0.2);
            $comLIGHT = nexus_colourBrightness($com, 0.1);
            $comText = (nexus_lumos($com) == 'light' ? $comDARK : $comLIGHT);

    header('Content-type: text/css');
    header('Cache-control: must-revalidate'); 

    foreach ($nexusModeList as $mode) { 
?>

.<?php echo $mode; ?> [class$="ONLY"]:not(.<?php echo $mode; ?>ONLY) {
    display:none !important;
}

<?php } ?>

/* ----- NEW STYLES ----- */
.tbs:not(p), .low:not(p), .textBubble.active:not(p) {
    background:<?php echo $tbs; ?>;
}
.assigned:not(p) {
    background:<?php echo $ass; ?>;
}

.progress:not(p) {
    background:<?php echo $pro; ?>;
}

.overdue:not(p):not(span), .rejected:not(p):not(span), .expired:not(p):not(span) {
    background:<?php echo $rej; ?>;
}

.approval:not(p), .signoff:not(p), .proof:not(p) {
    background:<?php echo $sig; ?>;
}

.high:not(p):not(span) {
    background-color: <?php echo $high; ?>;
    background-image: url("data:image/svg+xml,%3Csvg width='100' height='20' viewBox='0 0 100 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M21.184 20c.357-.13.72-.264 1.088-.402l1.768-.661C33.64 15.347 39.647 14 50 14c10.271 0 15.362 1.222 24.629 4.928.955.383 1.869.74 2.75 1.072h6.225c-2.51-.73-5.139-1.691-8.233-2.928C65.888 13.278 60.562 12 50 12c-10.626 0-16.855 1.397-26.66 5.063l-1.767.662c-2.475.923-4.66 1.674-6.724 2.275h6.335zm0-20C13.258 2.892 8.077 4 0 4V2c5.744 0 9.951-.574 14.85-2h6.334zM77.38 0C85.239 2.966 90.502 4 100 4V2c-6.842 0-11.386-.542-16.396-2h-6.225zM0 14c8.44 0 13.718-1.21 22.272-4.402l1.768-.661C33.64 5.347 39.647 4 50 4c10.271 0 15.362 1.222 24.629 4.928C84.112 12.722 89.438 14 100 14v-2c-10.271 0-15.362-1.222-24.629-4.928C65.888 3.278 60.562 2 50 2 39.374 2 33.145 3.397 23.34 7.063l-1.767.662C13.223 10.84 8.163 12 0 12v2z' fill='<?php echo $highDARK; ?>' fill-opacity='0.3' fill-rule='evenodd'/%3E%3C/svg%3E");
}

.completion:not(p), .complete:not(p) {
    background:<?php echo $com; ?>;
}

.tbs.textBubble:hover, .low.textBubble:hover, .assigned.textBubble:hover, .textBubble.active:hover {
    border:1px solid <?php echo $tbs; ?>;
}

.assigned.textBubble:hover {
    border:1px solid <?php echo $ass; ?>;
}

.overdue.textBubble:hover, .rejected.textBubble:hover, .expired.textBubble:hover {
    border:1px solid <?php echo $rej; ?>;
}

.approval.textBubble:hover, .signoff.textBubble:hover, .proof.textBubble:hover {
    border:1px solid <?php echo $sig; ?>;
}

.high.textBubble:hover {
    border:1px solid <?php echo $high; ?>;
}

.progress.textBubble:hover {
    border:1px solid <?php echo $pro; ?>;
}

.completion.textBubble:hover, .complete.textBubble:hover {
    border:1px solid <?php echo $com; ?>;
}

.tbs h1, .tbs i, .tbs h3.reqID span, .tbs .singleRequestDate, .low h1, .low i, .low h3.reqID span, .low .singleRequestDate, .textBubble.active h1, .textBubble.active i, .assigned h1, .assigned i, .textBubble.active h3.reqID span, .assigned h3.reqID span {
    color:<?php echo $assDARK; ?>;
}

.assigned h1, .assigned i, .assigned h3.reqID span, .assigned  .singleRequestDate {
    color:<?php echo $assDARK; ?>;
}

.overdue h1, .overdue i, .overdue h3.reqID span, .overdue .singleRequestDate, .expired h1, .expired i, .expired h3.reqID span, .expired .singleRequestDate, .rejected h1, .rejected i, .rejected h3.reqID span, .rejected .singleRequestDate {
    color:<?php echo $rejDARK; ?>;
}

.complete h1, .complete i, .high h1, .high i, .medium h1, .medium i, .high h3.reqID span, .medium h3.reqID span, .complete .singleRequestDate, .high .singleRequestDate, .medium .singleRequestDate {
    color:#ffffff;
}

.approval h1, .approval i, .signoff h1, .signoff i, .proof h1, .proof i, .approval h3.reqID span, .signoff h3.reqID span, .proof h3.reqID span, .approval .singleRequestDate, .signoff .singleRequestDate, .proof .singleRequestDate {
    color:<?php echo $sigDARK; ?>;
}

.progress h1, .progress i, .progress h3.reqID span, .progress .singleRequestDate {
    color:<?php echo $proDARK; ?>;
}

.competion h1, .competion i, .completion h3.reqID span, .complete h1, .complete i, .complete h3.reqID span, .completion .singleRequestDate, .complete .singleRequestDate {
    color:<?php echo $comDARK; ?>;
}

.requestCard.expired h3.reqID span {
    color:#2f2f2f;
}

.tbs .subDate, .low .subDate, .assigned .subDate, .textBubble.active .subDate {
    color:<?php echo $tbsLIGHT; ?>;
}

.assigned .subDate {
    color:<?php echo $assLIGHT; ?>;
}

.overdue .subDate, .rejected .subDate, .expired .subDate {
    color:<?php echo $rejLIGHT; ?>;
}

.high .subDate, .medium .subDate {
    color:#ffffff;
}

.approval .subDate, .signoff .subDate, .proof .subDate {
    color:<?php echo $sigLIGHT; ?>;
}

.progress .subDate{
    color:<?php echo $proLIGHT; ?>;
}

.completion .subDate, .complete .subDate {
    color:<?php echo $comLIGHT; ?>;
}

.requestCard.expired .subDate {
    color:#e0e0e0;
}

.mockupNotification i {
    color:white;
}

p.job {
    font-size:13px;
    margin-top:4px;
    color:#666666;
}

p.tbs.name, p.low.name, p.active.name {
    color:<?php echo $tbsDARK; ?>;
}

p.assigned.name {
    color:<?php echo $assDARK; ?>;
}

.high .reqStatus, .medium .reqStatus {
    font-weight:bold;
    color:#ffffff;
}

p.approval.name, p.signoff.name, p.proof.name {
    color:<?php echo $sigDARK; ?>;
}

p.progress.name {
    color:<?php echo $proDARK; ?>;
}

p.completion.name, p.complete.name {
    color:<?php echo $comDARK; ?>;
}

p.print.name, p.high.name, p.medium.name, p.overdue.name, p.expired.name, p.rejected.name {
    color:<?php echo $rejDARK; ?>;
}

.requestCard__header.tbs *{ color:<?php echo $tbsText; ?>; }

.requestCard__header.assigned *{ color:<?php echo $assText; ?>; }

.requestCard__header.overdue *, 
.requestCard__header.expired *, 
.requestCard__header.rejected *{ color:<?php echo $rejText; ?>; }

.requestCard__header .subDate.overdue { color:#ff0000; }

.requestCard__header.approval *, 
.requestCard__header.signoff *, 
.requestCard__header.proof * { color:<?php echo $sigText; ?>; }

.requestCard__header.progress * { color:<?php echo $proText; ?>; }

.requestCard__header.competion *, 
.requestCard__header.complete * { color:<?php echo $comText; ?>; }

.requestCard__header.complete *, 
.requestCard__header.high *, 
.requestCard__header.medium,
.requestCard__header .subDate { color:#ffffff; }