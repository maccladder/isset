
     <div class="card">
        <header class="card-header">
            <p class="card-header-title">CAPTURE D'ECRAN DU RAPPORT DE L'AGENT : {{ $rapport->nomcomplet }}</p>
        </header>
        <div class="card-content">
            <div class="content">
                <p>Enregistré le : {{ $rapport->created_at }}</p>
                <hr>
                <p><img src="{{ url('public/Image/'.$rapport->screenshot) }}" style="height: 500px; width: 500px;"></p>
            </div>
        </div>
    </div>

    <a href="{{ route('rapport') }}">Retour aux rapports</a>

   
