<select id="month" onchange="getYearAndMonth();">
    {#    <option>January</option>#}
    {#    <option>February</option>#}
    {#    <option>March</option>#}
    {#    <option selected>April</option>#}
    {#    <option>May</option>#}
    {#    <option>June</option>#}
    {#    <option>July</option>#}
    {#    <option>August</option>#}
    {#    <option>September</option>#}
    {#    <option>October</option>#}
    {#    <option>November</option>#}
    {#    <option>December</option>#}
    {% for month in months %}
        {% if month['number'] === currentMonth %}
            <option value="{{ month['number'] }}" selected>{{ month['name'] }}</option>
        {% else %}
            <option value="{{ month['number'] }}">{{ month['name'] }}</option>
        {% endif %}

    {% endfor %}
</select>
<select id="year" onchange="getYearAndMonth();">
    <option selected>{{ year }}</option>

</select>
<table class="table table-bordered" style="width: auto;position: absolute;">
    <thead>
    <tr>
        <th><a style="color: #8FA57E;" href="#" onclick="showHide();">Hide/Show</a></th>
        <th style="padding-left: 50px;padding-right: 50px;">{{ currentUser.name }}</th>
        {% for user in users %}
            <th style="padding-left: 50px;padding-right: 50px;">{{ user.name }}</th>
        {% endfor %}
    </tr>
    </thead>
    <tbody id="tBody" value="open">


    {% for index,day in days %}
        {#        if is current date#}



        {% if isCurrentDate %}
            {#            if day is current day#}
            {% if day['day'] == currentDay %}

                {#                if is day off#}
                {% if day['name']=='Sunday' or day['name']=='Satuday' %}
                    <tr class="notCuurentDay">
                        <td>
                            {{ day['number'] }}<br>{{ day['name'] }}
                        </td>
                        <td>
                            <input type="checkbox" disabled><br>
                        </td>
                        {% for user in users %}
                            <td>
                                <input type="checkbox" disabled>
                            </td>
                        {% endfor %}

                    </tr>
                    {#                    if is not day off#}
                {% else %}
                    <tr style="background-color: #EDEFD1;">
                        <td>
                            {{ day['number'] }}<br>{{ day['name'] }}
                        </td>
                        <td>
                            <input type="checkbox" checked><br>
                            <input type="button" value="start">
                            <input type="button" value="stop">
                        </td>
                        {% for user in users %}
                            <td>

                            </td>
                        {% endfor %}
                    </tr>
                {% endif %}
                {#                if is not current day#}
            {% else %}

                {% if day['name']=='Sunday' or day['name']=='Satuday' %}
                    {{ day['day'] }}
                    <tr class="notCuurentDay">

                        <td>
                            {{ day['number'] }}<br>{{ day['name'] }}
                        </td>
                        <td>
                            <input type="checkbox" disabled>

                        </td>
                        {% for user in users %}
                            <td>
                                <input type="checkbox" disabled>
                            </td>

                        {% endfor %}
                    </tr>
                {% else %}
                    {#                    if day is less than current day#}

                    {% if day['day']<currentDay %}

                        <tr style="background-color: #F2FFCF;" class="notCuurentDay">

                            <td>
                                {{ day['day'] }}<{{ currentDay }} index:{{ index }}<br>
                                {{ day['number'] }}<br>{{ day['name'] }}
                            </td>
                            <td>
                                <input type="checkbox" checked disabled><br>
                                {% for hour in hoursCurrentUser %}
                                    {% if day['day']== hour.day %}
                                        {{ hour.start }}-{{ hour.end }}<br>
                                    {% endif %}
                                {% endfor %}
                            </td>

                            {% for user in users %}
                                <td>
                                    <input type="checkbox" disabled checked>
                                    <br>
                                    {% for hour in hoursOtherUser %}
                                        {% if day['day']== hour.day and user.id== hour.userId %}
                                            {{ hour.start }}-{{ hour.end }}<br>
                                        {% endif %}

                                    {% endfor %}
                                    <br>
                                </td>

                            {% endfor %}
                        </tr>
                        {#                    if day is not less than current day#}
                    {% else %}
                        <tr style="background-color: #F2FFCF;" class="notCuurentDay">

                            <td>
                                {{ day['day'] }}>{{ currentDay }} index:{{ index }}<br>2<br>
                                {{ day['number'] }}<br>{{ day['name'] }}
                            </td>
                            <td>
                                <input type="checkbox" checked>

                            </td>
                            {% for user in users %}
                                <td>
                                    <input type="checkbox" disabled checked>
                                    <br>

                                </td>

                            {% endfor %}
                        </tr>
                    {% endif %}
                {% endif %}



            {% endif %}
            {#            if is not current date#}

        {% else %}
            {#       if is old date#}
            {% if oldNew==1 %}
                {#               if day is day off#}
                {% if day['name']=='Sunday' or day['name']=='Satuday' %}
                    <tr>


                        <td>
                            {{ day['number'] }}<br>{{ day['name'] }}
                        </td>
                        <td>
                            <input type="checkbox" disabled>

                        </td>
                        {% for user in users %}
                            <td>
                                <input type="checkbox" disabled>
                            </td>

                        {% endfor %}
                    </tr>
                    {#               if day is not day off#}
                {% else %}
                    <tr style="background-color: #F2FFCF;">
                        <td>
                            {{ day['number'] }}<br>{{ day['name'] }}
                        </td>
                        <td>
                            <input type="checkbox" checked disabled>
                            <br>
                            {% for hour in hoursCurrentUser %}
                                {% if day['day']== hour.day %}
                                    {{ hour.start }}-{{ hour.end }}<br>
                                {% endif %}

                            {% endfor %}
                        </td>
                        {% for user in users %}
                            <td>
                                <input type="checkbox" disabled checked>
                                <br>
                                {% for hour in hoursOtherUser %}
                                    {% if day['day']== hour.day and user.id== hour.userId %}
                                        {{ hour.start }}-{{ hour.end }}<br>
                                    {% endif %}

                                {% endfor %}
                            </td>

                        {% endfor %}
                    </tr>
                {% endif %}
                {# if is new date#}
            {% else %}
                {% if day['name']=='Sunday' or day['name']=='Satuday' %}
                    <tr>


                        <td>
                            {{ day['number'] }}<br>{{ day['name'] }}
                        </td>
                        <td>
                            <input type="checkbox" disabled>
                        </td>
                        {% for user in users %}
                            <td>
                                <input type="checkbox" disabled>
                            </td>

                        {% endfor %}
                    </tr>
                {% else %}
                    <tr style="background-color: #F2FFCF;">
                        <td>
                            {{ day['number'] }}<br>{{ day['name'] }}
                        </td>
                        <td>
                            <input type="checkbox" checked>

                        </td>
                        {% for user in users %}
                            <td>
                                <input type="checkbox" disabled checked>

                            </td>

                        {% endfor %}
                    </tr>
                {% endif %}
            {% endif %}

        {% endif %}
        {#        if date is current#}

    {% endfor %}


    </tbody>
</table>
<input value="{{ isCurrentDate }}" id="isCurrentDate" hidden>
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