
<a class="btn-primary link-padding" id="open_detail_rapport"  data-id="{{ $id }}" href="javascript:void(0);" data-bs-toggle="tooltip"  role="button"><i class="fa fa-edit"></i></a>

<a class="btn-danger link-padding" href="javascript:void(0);" onclick="deleteFuncRapport({{ $id }})" data-bs-toggle="tooltip" role="button"><i class="fa fa-trash-o"></i></a>

<a href="rapports/{{ $id }}/screenshot" class="btn-success link-padding" data-toggle="popover" data-trigger="hover" data-placement ="right" title="Cliquez pour voir la capture"><i class="fa fa-camera"></i></a>



