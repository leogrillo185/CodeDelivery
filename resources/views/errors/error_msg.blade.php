@if($errors->any())
    @foreach($errors->all() as $error)
        <ul class="alert alert-danger">
            <li style="margin-left:15px;">{{ $error }}</li>
        </ul>
    @endforeach
@endif