
{#{{ calTimeDiff('18:45:00','19:10:00') }}#}
{#{{ getResult() }}#}
{{ year }}{{ month }}{{ today }}


<table class="table table-bordered" style="width: auto;position: absolute;">
    <thead>
    <tr>
        <th><a style="color: #8FA57E;" href="#" onclick="showHide();">Hide/Show</a></th>
        <th style="padding-left: 50px;padding-right: 50px;">{{ currentUser.name }}</th>
        {% for user in otherUsers %}
            <th style="padding-left: 50px;padding-right: 50px;">{{ user.name }}</th>
        {% endfor %}

    </tr>
    </thead>
    <tbody id="tBody">


    {% for index,day in days %}
        {#        if day is sunday or satuday#}
        {% if day['name']=='Sunday' or day['name']=='Satuday' or day['dayOff']==1 %}
            <tr>
                <td>
                    {{ day['number'] }}<br>{{ day['name'] }}
                </td>
                <td>
                    <input type="checkbox" disabled><br>
                </td>
                {% for otherUser in otherUsers %}
                    <td>
                        <input type="checkbox" disabled>
                    </td>
                {% endfor %}
            </tr>
            {#        if day is not  sunday or satuday#}
        {% else %}
            {#            if month and year are equals to  current year and month#}
            {% if currentOldNewDate==1 %}
                {#                if day is  today#}
                {% if day['day']==today %}
                    <tr style="background-color: #EDEFD1;">
                        <td>
                            {{ day['number'] }}<br>{{ day['name'] }}
                        </td>
                        <td>

                            <input type="checkbox" checked><br>
                            {% if currentUserTodayHours|length>0 %}
                                {% for hour in currentUserTodayHours %}
                                    {{ hour.start }}
                                    -
                                    {% if  endTimeIsNullInit(hour.end,hour.id) %}
                                        {{ hour.end }}
                                        <br>
                                    {% endif %}
                                {% endfor %}
                                {% if endTimeIsnull() %}
                                    {#                                    {{ getHourEndId() }}#}
                                    <input type="button" onclick="stop( {{ getHourEndId() }})"
                                           value="stop">
                                {% else %}
                                    <input type="button"
                                           onclick="start({{ currentUser.id }})"
                                           value="start">
                                {% endif %}
                                <br>
                                Total: {{ getTotalHoursForToday(currentUser.id,year,month,today) }}

                            {% else %}
                                <input type="button"
                                       onclick="start({{ currentUser.id }},true)"
                                       value="start">
                            {% endif %}
                            {#                                                        {% if check %}#}
                            {#                                                            <input type="button" value="stop">#}
                            {#                                                        {% endif %}#}
                            {#                                                        <input type="button"#}
                            {#                                                               onclick="start({{ year }},{{ month }},{{ today }},{{ currentUser.id }})"#}
                            {#                                                               value="start">#}

                        </td>
                        {% for otherUser in otherUsers %}
                            <td>

                            </td>
                        {% endfor %}
                    </tr>
                {% endif %}
                {#                if day is new#}
                {% if day['day']>today %}
                    <tr style="background-color: #F2FFCF;">
                        <td>
                            {{ day['number'] }}<br>{{ day['name'] }}
                        </td>
                        <td>
                            <input type="checkbox" checked>
                        </td>
                        {% for otherUser in otherUsers %}
                            <td>
                                <input type="checkbox" disabled><br>

                            </td>
                        {% endfor %}
                    </tr>
                {% endif %}
                {#                if day is old#}
                {% if day['day']<today %}
                    <tr style="background-color: #F2FFCF;">
                        <td>
                            {{ day['number'] }}<br>{{ day['name'] }}
                        </td>
                        {% set style1 = 'style=""' %}
                        {% for late in currentUserLateList %}
                            {% if day['day']==late.day %}
                                {% set style1 = 'style="background-color: #FFB9B2;"' %}
                                {% break %}
                            {% endif %}
                        {% endfor %}
                        <td {{ style1 }}>
                            <input type="checkbox" disabled checked><br>
                            {% for hour in currentUserHours %}
                                {% if day['day']== hour.day %}
                                    {{ hour.start }}-{{ hour.end }}<br>
                                    {{ calTimeDiff(hour.start, hour.end) }}
                                {% endif %}
                            {% endfor %}
                            {% if resultIsNotEmpty() %}
                                {% set result =getResult() %}

                                {% if  getLessTime( result) %}
                                    <span style="color: red;">
                                    Total: {{ result }}<br>
                                    Less: {{ getLessTime( result) }}
                                    </span>
                                {% else %}
                                    <span style="color: #008000;">
                                    Total: {{ result }}
                                    </span>
                                {% endif %}
                            {% endif %}
                        </td>
                        {% for otherUser in otherUsers %}
                            {% set style2 = 'style=""' %}
                            {% for late in otherUserLateList %}
                                {% if day['day']==late.day and late.userId==otherUser.id %}
                                    {% set style2 = 'style="background-color: #FFB9B2;"' %}
                                    {% break %}
                                {% endif %}
                            {% endfor %}
                            <td {{ style2 }}>
                                <input type="checkbox" disabled><br>
                                {% for hour in otherUsersHours %}
                                    {% if day['day']== hour.day and otherUser.id== hour.userId %}
                                        {{ hour.start }}-{{ hour.end }}<br>
                                        {{ calTimeDiff(hour.start, hour.end) }}
                                    {% endif %}

                                {% endfor %}
                                {% if resultIsNotEmpty() %}
                                    {% set result =getResult() %}

                                    {% if  getLessTime( result) %}
                                        <span style="color: red;">
                                    Total: {{ result }}<br>
                                    Less: {{ getLessTime( result) }}
                                    </span>
                                    {% else %}
                                        <span style="color: #008000;">
                                    Total: {{ result }}
                                    </span>
                                    {% endif %}
                                {% endif %}

                            </td>
                        {% endfor %}
                    </tr>
                {% endif %}

            {% endif %}
            {#            if month or year is older than current year and month#}
            {% if currentOldNewDate==2 %}
                <tr style="background-color: #F2FFCF;">
                    <td>
                        {{ day['number'] }}<br>{{ day['name'] }}
                    </td>

                    {#                    {% for  hour in currentUserHours %}#}
                    {#                        {% if day['day']==hour.day %}#}
                    {#                            {% set start = hour.start %}#}
                    {#                            {% break %}#}
                    {#                        {% endif %}#}
                    {#                    {% endfor %}#}
                    {% set style1 = 'style=""' %}
                    {% for late in currentUserLateList %}
                        {% if day['day']==late.day %}
                            {% set style1 = 'style="background-color: #FFB9B2;"' %}
                            {% break %}
                        {% endif %}
                    {% endfor %}

                    {#                    {% if start is defined %}#}
                    {#                        {% if isLate(start) %}#}
                    {#                            {% set style = 'style="background-color: #FFB9B2;"' %}#}
                    {#                        {% endif %}#}
                    {#                    {% endif %}#}
                    {#                    {% set start = false %}#}

                    <td {{ style1 }}>


                        <input type="checkbox" disabled checked><br>
                        {#                                                {{ currentUserHours|length }}#}
                        {#                        {% if currentUserHours|length!=0 %}#}
                        {% for hour in currentUserHours %}

                            {% if day['day']== hour.day %}
                                {{ hour.start }}-{{ hour.end }}<br>
                                {{ calTimeDiff(hour.start, hour.end) }}
                                {#                                <input hidden type="text" onload="getTimeDiff({{ hour.start }},{{ hour.end }})">#}
                            {% endif %}
                        {% endfor %}
                        {% if resultIsNotEmpty() %}
                            {% set result =getResult() %}

                            {% if  getLessTime( result) %}
                                <span style="color: red;">
                                    Total: {{ result }}<br>
                                    Less: {{ getLessTime( result) }}
                                    </span>
                            {% else %}
                                <span style="color: #008000;">
                                    Total: {{ result }}
                                    </span>
                            {% endif %}
                        {% endif %}


                        {#                        {% endif %}#}


                        {#                        <input type="text" value="" onload="getResult(this);">#}
                    </td>
                    {% for otherUser in otherUsers %}
                        {% set style2 = 'style=""' %}
                        {% for late in otherUserLateList %}
                            {% if day['day']==late.day and late.userId==otherUser.id %}
                                {% set style2 = 'style="background-color: #FFB9B2;"' %}
                                {% break %}
                            {% endif %}
                        {% endfor %}


                        <td {{ style2 }}>
                            <input type="checkbox" disabled checked><br>
                            {% for hour in otherUsersHours %}
                                {% if day['day']== hour.day and otherUser.id== hour.userId %}
                                    {{ hour.start }}-{{ hour.end }}<br>
                                    {{ calTimeDiff(hour.start, hour.end) }}
                                {% endif %}

                            {% endfor %}
                            {% if resultIsNotEmpty() %}
                                {% set result =getResult() %}

                                {% if  getLessTime( result) %}
                                    <span style="color: red;">
                                    Total: {{ result }}<br>
                                    Less: {{ getLessTime( result) }}
                                    </span>
                                {% else %}
                                    <span style="color: #008000;">
                                    Total: {{ result }}
                                    </span>
                                {% endif %}
                            {% endif %}


                        </td>
                    {% endfor %}
                </tr>

            {% endif %}
            {#            if month or year is newer than current year and month#}
            {% if currentOldNewDate==3 %}
                <tr style="background-color: #F2FFCF;">
                    <td>
                        {{ day['number'] }}<br>{{ day['name'] }}
                    </td>
                    <td>
                        <input type="checkbox" checked>
                    </td>
                    {% for otherUser in otherUsers %}
                        <td>
                            <input type="checkbox" disabled><br>

                        </td>
                    {% endfor %}
                </tr>
            {% endif %}
        {% endif %}


    {% endfor %}


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