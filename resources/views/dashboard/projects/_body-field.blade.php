{{-- Rich text editor for the "Full Description" field. Quill stores its
     output as HTML in the hidden #body-input textarea, which is what
     actually gets submitted with the form. --}}
<div class="form-group">
  <label class="f-label">Full Description</label>
  <textarea name="body" id="body-input" style="display:none">{{ old('body', $project->body ?? '') }}</textarea>
  <div id="body-editor" class="rte-editor"></div>
  <div class="f-hint">This appears on the project's detail page when someone clicks to read more</div>
  @error('body')<div class="field-error">{{ $message }}</div>@enderror
</div>

@push('head')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet"/>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
(function () {
  var input = document.getElementById('body-input');

  var quill = new Quill('#body-editor', {
    theme: 'snow',
    placeholder: 'Write a detailed description of this project — what it involved, what you built, challenges, outcomes…',
    modules: {
      toolbar: [
        [{ header: [2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['blockquote', 'link'],
        ['clean']
      ]
    }
  });

  if (input.value.trim()) {
    quill.clipboard.dangerouslyPasteHTML(input.value);
  }

  input.closest('form').addEventListener('submit', function () {
    var html = quill.root.innerHTML;
    input.value = (html === '<p><br></p>') ? '' : html;
  });
})();
</script>
@endpush
