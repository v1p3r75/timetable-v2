@php
$route = Route::currentRouteName()
@endphp
<section id="sidebar">
	<a href="#" class="brand">
		<i class='bx bxs-book'></i>
		<span class="text">LTN-Emploi</span>
	</a>
	@if(in_array(Auth::user()->role_id, [App\Models\Role::CENSOR, App\Models\Role::DEPUTY_CENSOR]))
	<ul class="side-menu top">
		<li @class(['', 'active'=> str_starts_with($route , 'admin.dash')])>
			<a href="{{ route('admin.dashboard') }}">
				<i class='bx bxs-dashboard'></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li @class(['', 'active'=> str_starts_with($route , 'timetable.')])>
			<a href="{{ route('timetable.index') }}">
				<i class='bx bxs-calendar'></i>
				<span class="text">Emplois du Temps</span>
			</a>
		</li>
		<li @class(['', 'active'=> str_starts_with($route , 'collaborator.')])>
			<a href="{{ route('collaborator.index') }}">
				<i class='bx bxs-user-account'></i>
				<span class="text">Collaborateurs</span>
			</a>
		</li>
		<li @class(['', 'active'=> str_starts_with($route , 'teacher.')])>
			<a href="{{ route('teacher.index') }}">
				<i class='bx bxs-user-check'></i>
				<span class="text">Professeurs</span>
			</a>
		</li>

		<li @class(['', 'active'=> str_starts_with($route , 'student.')])>
			<a href="{{ route('student.index') }}">
				<i class='bx bxs-group'></i>
				<span class="text">Elèves</span>
			</a>
		</li>
		<li @class(['', 'active'=> str_starts_with($route , 'subject.')])>
			<a href="{{ route('subject.index') }}">
				<i class='bx bxs-book'></i>
				<span class="text">Cours</span>
			</a>
		</li>
		<li @class(['', 'active'=> str_starts_with($route , 'classroom.')])>
			<a href="{{route('classroom.index')}}">
				<i class='bx bxs-building'></i>
				<span class="text">Salles de Cours</span>
			</a>
		</li>
		<li @class(['', 'active'=> str_starts_with($route , 'level.')])>
			<a href="{{ route('level.index') }}">
				<i class='bx bxs-graduation'></i>
				<span class="text">Filières</span>
			</a>
		</li>
	</ul>
	@elseif (Auth::user()->role_id === App\Models\Role::STUDENT)
	<ul class="side-menu top">
		<li @class(['', 'active'=> str_starts_with($route , 'user.dashboard')])>
			<a href="{{ route("user.dashboard") }}">
				<i class='bx bxs-dashboard'></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li @class(['', 'active'=> $route === 'student.timetable.index'])>
			<a href="{{ route('student.timetable.index') }}">
				<i class='bx bxs-calendar'></i>
				<span class="text">Emplois du Temps</span>
			</a>
		</li>
		<li @class(['', 'active'=> str_starts_with($route , 'faq.')])>
			<a href="{{ route('faq.index') }}">
				<i class='bx bxs-help-circle'></i>
				<span class="text">FAQ</span>
			</a>
		</li>

	</ul>
	@else
	<ul class="side-menu top">
		<li @class(['', 'active'=> str_starts_with($route , 'teacher.dashboard')])>
			<a href="{{ route("teacher.dashboard") }}">
				<i class='bx bxs-dashboard'></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li @class(['', 'active'=> str_starts_with($route,'teacher.timetable.index')])>
			<a href="{{ route('teacher.timetable.index') }}">
				<i class='bx bxs-calendar'></i>
				<span class="text">Emplois du Temps</span>
			</a>
		</li>
		<li @class(['', 'active'=> str_starts_with($route , 'faq.')])>
			<a href="{{ route('faq.index') }}">
				<i class='bx bxs-help-circle'></i>
				<span class="text">FAQ</span>
			</a>
		</li>

	</ul>
	@endif
	<ul class="side-menu">
		<li @class(['', 'active'=> str_starts_with($route , 'profile.')]) >
			<a href="{{ route('profile.edit') }}">
				<i class='bx bxs-cog'></i>
				<span class="text">Mon compte</span>
			</a>
		</li>
	</ul>
	<p class="text-muted text-center">&copy; {{ date('Y') }} - LT Natitingou</p>
</section>