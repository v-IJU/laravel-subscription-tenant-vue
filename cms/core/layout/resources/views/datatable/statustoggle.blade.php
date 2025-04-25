<div class="form-check form-switch" style="font-size: 18px">
    <input class="form-check-input" type="checkbox" id={{ $data->id }}
        {{ @$data->status == 'Enabled' ? 'checked' : '' }} role="switch"
        onchange="GeneralConfig.DoStatusChange(this.checked ? 1:0,this.id)">

</div>
