
{# {{ flashSession.output() }}#}
{#{{ form('method':'post','class': 'form-search') }}#}
{#<p>#}
{#    {{ form.render('email') }}#}
{#</p>#}
{#<p>#}
{#    {{ form.render('password') }}#}
{#</p>#}
{#<p>#}
{#    {{ form.render('login') }}#}
{#</p>#}
{#{{ form.render('csrf', ['value': security.getToken()]) }}#}
{#</form>#}
admin content