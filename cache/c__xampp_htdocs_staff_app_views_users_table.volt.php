


<?= $year ?><?= $month ?><?= $today ?>


<table class="table table-bordered" style="width: auto;position: absolute;">
    <thead>
    <tr>
        <th><a style="color: #8FA57E;" href="#" onclick="showHide();">Hide/Show</a></th>
        <th style="padding-left: 50px;padding-right: 50px;"><?= $currentUser->name ?></th>
        <?php foreach ($otherUsers as $user) { ?>
            <th style="padding-left: 50px;padding-right: 50px;"><?= $user->name ?></th>
        <?php } ?>

    </tr>
    </thead>
    <tbody id="tBody">


    <?php foreach ($days as $index => $day) { ?>
        
        <?php if ($day['name'] == 'Sunday' || $day['name'] == 'Satuday' || $day['dayOff'] == 1) { ?>
            <tr>
                <td>
                    <?= $day['number'] ?><br><?= $day['name'] ?>
                </td>
                <td>
                    <input type="checkbox" disabled><br>
                </td>
                <?php foreach ($otherUsers as $otherUser) { ?>
                    <td>
                        <input type="checkbox" disabled>
                    </td>
                <?php } ?>
            </tr>
            
        <?php } else { ?>
            
            <?php if ($currentOldNewDate == 1) { ?>
                
                <?php if ($day['day'] == $today) { ?>
                    <tr style="background-color: #EDEFD1;">
                        <td>
                            <?= $day['number'] ?><br><?= $day['name'] ?>
                        </td>
                        <td>

                            <input type="checkbox" checked><br>
                            <?php if ($this->length($currentUserTodayHours) > 0) { ?>
                                <?php foreach ($currentUserTodayHours as $hour) { ?>
                                    <?= $hour->start ?>
                                    -
                                    <?php if (lib\Funcions::endTimeIsNullInit($hour->end,$hour->id)) { ?>
                                        <?= $hour->end ?>
                                        <br>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (lib\Funcions::endTimeIsnull()) { ?>
                                    
                                    <input type="button" onclick="stop( <?= lib\Funcions::getHourEndId() ?>)"
                                           value="stop">
                                <?php } else { ?>
                                    <input type="button"
                                           onclick="start(<?= $currentUser->id ?>)"
                                           value="start">
                                <?php } ?>
                                <br>
                                Total: <?= lib\Funcions::getTotalHoursForToday($currentUser->id,$year,$month,$today) ?>

                            <?php } else { ?>
                                <input type="button"
                                       onclick="start(<?= $currentUser->id ?>,true)"
                                       value="start">
                            <?php } ?>
                            
                            
                            
                            
                            
                            

                        </td>
                        <?php foreach ($otherUsers as $otherUser) { ?>
                            <td>

                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                
                <?php if ($day['day'] > $today) { ?>
                    <tr style="background-color: #F2FFCF;">
                        <td>
                            <?= $day['number'] ?><br><?= $day['name'] ?>
                        </td>
                        <td>
                            <input type="checkbox" checked>
                        </td>
                        <?php foreach ($otherUsers as $otherUser) { ?>
                            <td>
                                <input type="checkbox" disabled><br>

                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                
                <?php if ($day['day'] < $today) { ?>
                    <tr style="background-color: #F2FFCF;">
                        <td>
                            <?= $day['number'] ?><br><?= $day['name'] ?>
                        </td>
                        <?php $style1 = 'style=""'; ?>
                        <?php foreach ($currentUserLateList as $late) { ?>
                            <?php if ($day['day'] == $late->day) { ?>
                                <?php $style1 = 'style="background-color: #FFB9B2;"'; ?>
                                <?php break; ?>
                            <?php } ?>
                        <?php } ?>
                        <td <?= $style1 ?>>
                            <input type="checkbox" disabled checked><br>
                            <?php foreach ($currentUserHours as $hour) { ?>
                                <?php if ($day['day'] == $hour->day) { ?>
                                    <?= $hour->start ?>-<?= $hour->end ?><br>
                                    <?= lib\Funcions::calculateTimeDiff($hour->start, $hour->end) ?>
                                <?php } ?>
                            <?php } ?>
                            <?php if (lib\Funcions::resultIsNotEmpty()) { ?>
                                <?php $result = lib\Funcions::getResult(); ?>

                                <?php if (lib\Funcions::getLessTime($result)) { ?>
                                    <span style="color: red;">
                                    Total: <?= $result ?><br>
                                    Less: <?= lib\Funcions::getLessTime($result) ?>
                                    </span>
                                <?php } else { ?>
                                    <span style="color: #008000;">
                                    Total: <?= $result ?>
                                    </span>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <?php foreach ($otherUsers as $otherUser) { ?>
                            <?php $style2 = 'style=""'; ?>
                            <?php foreach ($otherUserLateList as $late) { ?>
                                <?php if ($day['day'] == $late->day && $late->userId == $otherUser->id) { ?>
                                    <?php $style2 = 'style="background-color: #FFB9B2;"'; ?>
                                    <?php break; ?>
                                <?php } ?>
                            <?php } ?>
                            <td <?= $style2 ?>>
                                <input type="checkbox" disabled><br>
                                <?php foreach ($otherUsersHours as $hour) { ?>
                                    <?php if ($day['day'] == $hour->day && $otherUser->id == $hour->userId) { ?>
                                        <?= $hour->start ?>-<?= $hour->end ?><br>
                                        <?= lib\Funcions::calculateTimeDiff($hour->start, $hour->end) ?>
                                    <?php } ?>

                                <?php } ?>
                                <?php if (lib\Funcions::resultIsNotEmpty()) { ?>
                                    <?php $result = lib\Funcions::getResult(); ?>

                                    <?php if (lib\Funcions::getLessTime($result)) { ?>
                                        <span style="color: red;">
                                    Total: <?= $result ?><br>
                                    Less: <?= lib\Funcions::getLessTime($result) ?>
                                    </span>
                                    <?php } else { ?>
                                        <span style="color: #008000;">
                                    Total: <?= $result ?>
                                    </span>
                                    <?php } ?>
                                <?php } ?>

                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>

            <?php } ?>
            
            <?php if ($currentOldNewDate == 2) { ?>
                <tr style="background-color: #F2FFCF;">
                    <td>
                        <?= $day['number'] ?><br><?= $day['name'] ?>
                    </td>

                    
                    
                    
                    
                    
                    
                    <?php $style1 = 'style=""'; ?>
                    <?php foreach ($currentUserLateList as $late) { ?>
                        <?php if ($day['day'] == $late->day) { ?>
                            <?php $style1 = 'style="background-color: #FFB9B2;"'; ?>
                            <?php break; ?>
                        <?php } ?>
                    <?php } ?>

                    
                    
                    
                    
                    
                    

                    <td <?= $style1 ?>>


                        <input type="checkbox" disabled checked><br>
                        
                        
                        <?php foreach ($currentUserHours as $hour) { ?>

                            <?php if ($day['day'] == $hour->day) { ?>
                                <?= $hour->start ?>-<?= $hour->end ?><br>
                                <?= lib\Funcions::calculateTimeDiff($hour->start, $hour->end) ?>
                                
                            <?php } ?>
                        <?php } ?>
                        <?php if (lib\Funcions::resultIsNotEmpty()) { ?>
                            <?php $result = lib\Funcions::getResult(); ?>

                            <?php if (lib\Funcions::getLessTime($result)) { ?>
                                <span style="color: red;">
                                    Total: <?= $result ?><br>
                                    Less: <?= lib\Funcions::getLessTime($result) ?>
                                    </span>
                            <?php } else { ?>
                                <span style="color: #008000;">
                                    Total: <?= $result ?>
                                    </span>
                            <?php } ?>
                        <?php } ?>


                        


                        
                    </td>
                    <?php foreach ($otherUsers as $otherUser) { ?>
                        <?php $style2 = 'style=""'; ?>
                        <?php foreach ($otherUserLateList as $late) { ?>
                            <?php if ($day['day'] == $late->day && $late->userId == $otherUser->id) { ?>
                                <?php $style2 = 'style="background-color: #FFB9B2;"'; ?>
                                <?php break; ?>
                            <?php } ?>
                        <?php } ?>


                        <td <?= $style2 ?>>
                            <input type="checkbox" disabled checked><br>
                            <?php foreach ($otherUsersHours as $hour) { ?>
                                <?php if ($day['day'] == $hour->day && $otherUser->id == $hour->userId) { ?>
                                    <?= $hour->start ?>-<?= $hour->end ?><br>
                                    <?= lib\Funcions::calculateTimeDiff($hour->start, $hour->end) ?>
                                <?php } ?>

                            <?php } ?>
                            <?php if (lib\Funcions::resultIsNotEmpty()) { ?>
                                <?php $result = lib\Funcions::getResult(); ?>

                                <?php if (lib\Funcions::getLessTime($result)) { ?>
                                    <span style="color: red;">
                                    Total: <?= $result ?><br>
                                    Less: <?= lib\Funcions::getLessTime($result) ?>
                                    </span>
                                <?php } else { ?>
                                    <span style="color: #008000;">
                                    Total: <?= $result ?>
                                    </span>
                                <?php } ?>
                            <?php } ?>


                        </td>
                    <?php } ?>
                </tr>

            <?php } ?>
            
            <?php if ($currentOldNewDate == 3) { ?>
                <tr style="background-color: #F2FFCF;">
                    <td>
                        <?= $day['number'] ?><br><?= $day['name'] ?>
                    </td>
                    <td>
                        <input type="checkbox" checked>
                    </td>
                    <?php foreach ($otherUsers as $otherUser) { ?>
                        <td>
                            <input type="checkbox" disabled><br>

                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        <?php } ?>


    <?php } ?>


    </tbody>
</table>
<script>
    function start(userId, first = false) {
        window.location.href = '/staff/users/start/' + userId + "/" + first;
    }

    function stop(hourId) {
        window.location.href = '/staff/users/stop/' + hourId;
    }


    // var results = [];
    //
    // function getTimeDiff(startTime, endTime) {
    //     var startTime = startTime;
    //     var endTime = endTime;
    //     var startDate = new Date("January 1, 1970 " + startTime);
    //     var endDate = new Date("January 1, 1970 " + endTime);
    //     var timeDiff = Math.abs(startDate - endDate);
    //
    //     var hh = Math.floor(timeDiff / 1000 / 60 / 60);
    //     if (hh < 10) {
    //         hh = '0' + hh;
    //     }
    //     timeDiff -= hh * 1000 * 60 * 60;
    //     var mm = Math.floor(timeDiff / 1000 / 60);
    //     if (mm < 10) {
    //         mm = '0' + mm;
    //     }
    //     timeDiff -= mm * 1000 * 60;
    //     var ss = Math.floor(timeDiff / 1000);
    //     if (ss < 10) {
    //         ss = '0' + ss;
    //     }
    //     var result = {
    //         hh: hh,
    //         mm: mm,
    //         ss: ss
    //     };
    //     results.push(result);
    //     console.log('salam');
    //
    // }
    //
    // function getResult(e) {
    //     var newDate = new Date();
    //     for (var i = 0; i < results.length; i++) {
    //         newDate.setHours(results[i].hh);
    //         newDate.setMinutes(results[i].mm);
    //         newDate.setSeconds(results[i].ss);
    //
    //     }
    //     results = [];
    //     e.value='1';
    //     console.log(newDate);
    //
    // }
    //
    // getTimeDiff("09:20:00", "10:00:00");
    // getResult();
    // getTimeDiff("09:20:00", "10:00:00")
    // var newDate = new Date();
    // newDate.setHours(hh);
    // newDate.setMinutes(mm);
    // newDate.setSeconds(ss);
    // console.log(newDate);

    // alert("Time Diff- " + hh + ":" + mm + ":" + ss);
</script>