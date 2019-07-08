<?= hours:3 mins:0 ?>
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
        
        <?php if ($day['name'] == 'Sunday' || $day['name'] == 'Satuday') { ?>
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
                            <input type="button" value="start">
                            <input type="button" value="stop">
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
                        <td>
                            <input type="checkbox" disabled checked><br>
                            <?php foreach ($currentUserHours as $hour) { ?>
                                <?php if ($day['day'] == $hour->day) { ?>
                                    <?= $hour->start ?>-<?= $hour->end ?><br>
                                    <?= hours:3 mins:0 ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <?php foreach ($otherUsers as $otherUser) { ?>
                            <td>
                                <input type="checkbox" disabled><br>
                                <?php foreach ($otherUsersHours as $hour) { ?>
                                    <?php if ($day['day'] == $hour->day && $otherUser->id == $hour->userId) { ?>
                                        <?= $hour->start ?>-<?= $hour->end ?><br>
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
                    <td>
                        <input type="checkbox" disabled checked><br>
                        <?php foreach ($currentUserHours as $hour) { ?>
                            <?php if ($day['day'] == $hour->day) { ?>
                                <?= $hour->start ?>-<?= $hour->end ?><br>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <?php foreach ($otherUsers as $otherUser) { ?>
                        <td>
                            <input type="checkbox" disabled checked><br>
                            <?php foreach ($otherUsersHours as $hour) { ?>
                                <?php if ($day['day'] == $hour->day && $otherUser->id == $hour->userId) { ?>
                                    <?= $hour->start ?>-<?= $hour->end ?><br>
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