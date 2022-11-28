
     <div class="card">
        <header class="card-header">
            <p class="card-header-title">CAPTURE D'ECRAN DU RAPPORT DE L'AGENT : {{ $rapport->nomcomplet }}</p>
        </header>
        <div class="card-content">
            <div class="content">
                <p>Rapport du : {{ date("d-m-Y", strtotime($rapport->date)) }}</p>
                <p>Enregistré dans ISSET le : {{ date("d-m-Y", strtotime($rapport->created_at)) }} à {{ date("h:i", strtotime($rapport->created_at)) }}</p>
                <hr>
                <?php 
                    function isPDF($filename) {
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        return strcmp(strtolower($ext), "pdf") == 0;
                    }
                ?>
                @if ( !isPDF($rapport->screenshot) )
                    <p><img src="{{ url('Image/'.$rapport->screenshot) }}" style="height: 500px; width: 500px;"></p>
                @else
                    <p><embed src="{{url('Image/'.$rapport->screenshot.'#page=1')}}" type="application/pdf" width="500px" height="500px"></p>
                @endif
            </div>
        </div>

        
    </div>

    <a href="{{ route('rapport') }}">Retour aux rapports</a>

   
