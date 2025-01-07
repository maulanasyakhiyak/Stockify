import { ImagePreview ,trackingForm} from "../fitur"
const previewImage  =  new ImagePreview($('#logo'));
const trackElement = [
    $('#NEW_APP_NAME'),
    $('#logo'),
]
const track = new trackingForm(trackElement)
var data
track.tracking(() => {
    if(track.changed){
        $('#button-submit').attr('disabled', false)
        data = track.getValue()
    }else{
        $('#button-submit').attr('disabled', true)
    }
});

$('#FORM_SETTING_APP').on('submit', function(e){
    e.preventDefault()
    $('#logo').attr({ 
        id: 'logo-copy',
        type: 'file',
        name: 'logo',
    }).appendTo(this);
    $('<input>').attr({
        type: 'hidden',
        name: 'NEW_APP_NAME',
        value: data.NEW_APP_NAME
    }).appendTo(this);
    setTimeout(() => {
        this.submit();
    }, 0);
});


