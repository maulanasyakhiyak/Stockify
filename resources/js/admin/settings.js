import { ImagePreview ,trackingForm} from "../fitur"
const previewImage  =  new ImagePreview($('#logo'))
const trackElement = [
    $('#NEW_APP_NAME'),
    $('#logo'),
]
const track = new trackingForm(trackElement)

track.tracking(() => {
    if(track.changed){
        $('#button-submit').attr('disabled', false)
    }else{
        $('#button-submit').attr('disabled', true)
    }
})


