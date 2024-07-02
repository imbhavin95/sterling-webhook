@include('includes.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/codemirror.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.0/mode/javascript/javascript.min.js"></script>
<div class="container">
    <div class="row mt-5">
        <div class="p-5">
            <div class="p-3 ps-0">
                <h1>Write Your Code Here</h1>
            </div>
            <div class="row">
                <form class="form" action="{{ route('store-code') }}" method="POST">
                    @csrf
                    <div class="col-12 border border-secondary">
                        <input type="hidden" name="webhook_id" value="{{ $data->id }}">
                        @if(empty($data->enc_key))
                            <input type="hidden" name="editCode" value="0">
                            <textarea id="code-editor" name="code"></textarea>
                        @else
                            <input type="hidden" name="editCode" value="1">
                            <textarea id="code-editor" name="code">{{ decrypt($data->enc_key) }}</textarea>
                        @endif
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary" type="submit">Save Code</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("code-editor"), {
        lineNumbers: true, // Display line numbers
        mode: "javascript", // Set mode to JavaScript
        color: "white",
        display: "inline-block",
    });
</script>
@include('includes.footer')
