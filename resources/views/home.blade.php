@extends('layouts.app')
@section('content')
<div class="container">
	<v-app>
		<component v-bind:is="component" v-bind:plan="componentProps"/>
	</v-app>
</div>
@endsection
<style type="text/css">
	#app
	{
		background : initial
	}
</style>