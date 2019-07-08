{{ content() }}
<div align="center">

	{{ form('class': 'form-search') }}

		<div align="center">
			<h2>Sign Up</h2>
		</div>

		<table class="signup">
			<tr>
				<td align="right">{{ form.label('name') }}</td>
				<td>
					{{ form.render('name') }}
					{{ form.messages('name') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('login') }}</td>
				<td>
					{{ form.render('login') }}
					{{ form.messages('login') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('email') }}</td>
				<td>
					{{ form.render('email') }}
					{{ form.messages('email') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('password') }}</td>
				<td>
					{{ form.render('password') }}
					{{ form.messages('password') }}
				</td>
			</tr>
			<tr>
				<td align="right">{{ form.label('confirmPassword') }}</td>
				<td>
					{{ form.render('confirmPassword') }}
					{{ form.messages('confirmPassword') }}
				</td>
			</tr>
			<tr>
				<td align="right"></td>
				<td>{{ form.render('Sign Up') }}</td>
			</tr>
		</table>

		{{ form.render('csrf', ['value': security.getToken()]) }}
		{{ form.messages('csrf') }}

		<hr>

	</form>

</div>