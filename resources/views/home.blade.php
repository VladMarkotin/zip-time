@extends('layouts.app')
@section('content')
<div class="container">
	<v-app>
		
		<component v-bind:is="currComponentName" v-bind:data="currComponentProps">
	</v-app>
</div>
@endsection
<style>
	#app
	{
		background: initial;
	}
</style>