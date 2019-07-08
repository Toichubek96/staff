<select id="month" onchange="getYearAndMonth();">
    
    
    
    
    
    
    
    
    
    
    
    
    <?php foreach ($months as $month) { ?>
        <?php if ($month['number'] === $currentMonth) { ?>
            <option value="<?= $month['number'] ?>" selected><?= $month['name'] ?></option>
        <?php } else { ?>
            <option value="<?= $month['number'] ?>"><?= $month['name'] ?></option>
        <?php } ?>

    <?php } ?>
</select>
<select id="year" onchange="getYearAndMonth();">
    <option selected><?= $year ?></option>

</select>
<table class="table table-bordered" style="width: auto;position: absolute;">
    <thead>
    <tr>
        <th><a style="color: #8FA57E;" href="#" onclick="showHide();">Hide/Show</a></th>
        <th style="padding-left: 50px;padding-right: 50px;"><?= $currentUser->name ?></th>
        <?php foreach ($users as $user) { ?>
            <th style="padding-left: 50px;padding-right: 50px;"><?= $user->name ?></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody id="tBody" value="open">


    <?php foreach ($days as $index => $day) { ?>
        



        <?php if ($isCurrentDate) { ?>
            
            <?php if ($day['day'] == $currentDay) { ?>

                
                <?php if ($day['name'] == 'Sunday' || $day['name'] == 'Satuday') { ?>
                    <tr class="notCuurentDay">
                        <td>
                            <?= $day['number'] ?><br><?= $day['name'] ?>
                        </td>
                        <td>
                            <input type="checkbox" disabled><br>
                        </td>
                        <?php foreach ($users as $user) { ?>
                            <td>
                                <input type="checkbox" disabled>
                            </td>
                        <?php } ?>

                    </tr>
                    
                <?php } else { ?>
                    <tr style="background-color: #EDEFD1;">
                        <td>
                            <?= $day['number'] ?><br><?= $day['name'] ?>
                        </td>
                        <td>
                            <input type="checkbox" checked><br>
                            <input type="button" value="start">
                            <input type="button" value="stop">
                        </td>
                        <?php foreach ($users as $user) { ?>
                            <td>

                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                
            <?php } else { ?>

                <?php if ($day['name'] == 'Sunday' || $day['name'] == 'Satuday') { ?>
                    <?= $day['day'] ?>
                    <tr class="notCuurentDay">

                        <td>
                            <?= $day['number'] ?><br><?= $day['name'] ?>
                        </td>
                        <td>
                            <input type="checkbox" disabled>

                        </td>
                        <?php foreach ($users as $user) { ?>
                            <td>
                                <input type="checkbox" disabled>
                            </td>

                        <?php } ?>
                    </tr>
                <?php } else { ?>
                    

                    <?php if ($day['day'] < $currentDay) { ?>

                        <tr style="background-color: #F2FFCF;" class="notCuurentDay">

                            <td>
                                <?= $day['day'] ?><<?= $currentDay ?> index:<?= $index ?><br>
                                <?= $day['number'] ?><br><?= $day['name'] ?>
                            </td>
                            <td>
                                <input type="checkbox" checked disabled><br>
                                <?php foreach ($hoursCurrentUser as $hour) { ?>
                                    <?php if ($day['day'] == $hour->day) { ?>
                                        <?= $hour->start ?>-<?= $hour->end ?><br>
                                    <?php } ?>
                                <?php } ?>
                            </td>

                            <?php foreach ($users as $user) { ?>
                                <td>
                                    <input type="checkbox" disabled checked>
                                    <br>
                                    <?php foreach ($hoursOtherUser as $hour) { ?>
                                        <?php if ($day['day'] == $hour->day && $user->id == $hour->userId) { ?>
                                            <?= $hour->start ?>-<?= $hour->end ?><br>
                                        <?php } ?>

                                    <?php } ?>
                                    <br>
                                </td>

                            <?php } ?>
                        </tr>
                        
                    
                        <tr style="background-color: #F2FFCF;" class="notCuurentDay">

                            <td>
                                <?= $day['day'] ?>><?= $currentDay ?> index:<?= $index ?><br>2<br>
                                <?= $day['number'] ?><br><?= $day['name'] ?>
                            </td>
                            <td>
                                <input type="checkbox" checked>

                            </td>
                            <?php foreach ($users as $user) { ?>
                                <td>
                                    <input type="checkbox" disabled checked>
                                    <br>

                                </td>

                            <?php } ?>
                        </tr>
                    <?php } ?>
                <?php } ?>



            <?php } ?>
            

        <?php } else { ?>
            
            <?php if ($oldNew == 1) { ?>
                
                <?php if ($day['name'] == 'Sunday' || $day['name'] == 'Satuday') { ?>
                    <tr>


                        <td>
                            <?= $day['number'] ?><br><?= $day['name'] ?>
                        </td>
                        <td>
                            <input type="checkbox" disabled>

                        </td>
                        <?php foreach ($users as $user) { ?>
                            <td>
                                <input type="checkbox" disabled>
                            </td>

                        <?php } ?>
                    </tr>
                    
                <?php } else { ?>
                    <tr style="background-color: #F2FFCF;">
                        <td>
                            <?= $day['number'] ?><br><?= $day['name'] ?>
                        </td>
                        <td>
                            <input type="checkbox" checked disabled>
                            <br>
                            <?php foreach ($hoursCurrentUser as $hour) { ?>
                                <?php if ($day['day'] == $hour->day) { ?>
                                    <?= $hour->start ?>-<?= $hour->end ?><br>
                                <?php } ?>

                            <?php } ?>
                        </td>
                        <?php foreach ($users as $user) { ?>
                            <td>
                                <input type="checkbox" disabled checked>
                                <br>
                                <?php foreach ($hoursOtherUser as $hour) { ?>
                                    <?php if ($day['day'] == $hour->day && $user->id == $hour->userId) { ?>
                                        <?= $hour->start ?>-<?= $hour->end ?><br>
                                    <?php } ?>

                                <?php } ?>
                            </td>

                        <?php } ?>
                    </tr>
                <?php } ?>
                
            <?php } else { ?>
                <?php if ($day['name'] == 'Sunday' || $day['name'] == 'Satuday') { ?>
                    <tr>


                        <td>
                            <?= $day['number'] ?><br><?= $day['name'] ?>
                        </td>
                        <td>
                            <input type="checkbox" disabled>
                        </td>
                        <?php foreach ($users as $user) { ?>
                            <td>
                                <input type="checkbox" disabled>
                            </td>

                        <?php } ?>
                    </tr>
                
                    <tr style="background-color: #F2FFCF;">
                        <td>
                            <?= $day['number'] ?><br><?= $day['name'] ?>
                        </td>
                        <td>
                            <input type="checkbox" checked>

                        </td>
                        <?php foreach ($users as $user) { ?>
                            <td>
                                <input type="checkbox" disabled checked>

                            </td>

                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } ?>

        <?php } ?>
        

    <?php } ?>


    </tbody>
</table>
<input value="<?= $isCurrentDate ?>" id="isCurrentDate" hidden>
<script>
    var isCurrentDate = document.getElementById('isCurrentDate').value;
    console.log(isCurrentDate);

    function showHide() {
        var tBody = $('#tBody');
        var value = tBody.attr('value');
        if (value == 'open') {
            if (!isCurrentDate) {
                tBody.hide();
                tBody.attr('value', 'close')
            } else {
                $('.notCuurentDay').hide();
                tBody.attr('value', 'close')
            }

        } else {
            if (!isCurrentDate) {
                tBody.show();
                tBody.attr('value', 'open')
            } else {
                $('.notCuurentDay').show();
                tBody.attr('value', 'open')
            }
        }
    }

    function getYearAndMonth() {

        var month = $("#month option:selected").val();

        var year = $("#year option:selected").text();
        window.location.href = '/staff/users/index/' + year + '/' + month;

    }
</script>