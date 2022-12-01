
     <div class="card">
        <header class="card-header">
        </header>
        <div class="card-content">
            <div class="content">
                <p>Rapport du : {{ date("d-m-Y", strtotime($total->created_at)) }}</p>
                <p>Enregistré dans ISSET le : {{ date("d-m-Y", strtotime($total->created_at)) }} à {{ date("h:i", strtotime($total->created_at)) }}</p>
                <hr>                
                <p><embed src="{{url('Image/'.$total->screenshot.'#page=1')}}" type="application/pdf" width="500px" height="500px"></p>
            </div>
        </div>

        
    </div>

    <a href="{{ route('totals') }}">Retour aux rapports</a>

   
