{{-- CKEditor 5 rich text editor for the "Full Description" field.
     The editor writes its HTML into the hidden #body-input textarea,
     which is what actually gets submitted with the form. --}}
<div class="form-group">
  <label class="f-label">Full Description</label>
  <textarea name="body" id="body-input" style="display:none">{{ old('body', $project->body ?? '') }}</textarea>
  <div id="body-editor" class="ck-host"></div>
  <div class="f-hint">This appears on the project's detail page when someone clicks to read more</div>
  @error('body')<div class="field-error">{{ $message }}</div>@enderror
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
(function () {
  var input = document.getElementById('body-input');

  ClassicEditor
    .create(document.getElementById('body-editor'), {
      initialData: input.value,
      placeholder: 'Write a detailed description of this project — what it involved, what you built, challenges, outcomes…',
      toolbar: {
        items: [
          'heading', '|',
          'bold', 'italic', 'underline', 'strikethrough', '|',
          'bulletedList', 'numberedList', '|',
          'blockQuote', 'link', '|',
          'undo', 'redo'
        ]
      },
      heading: {
        options: [
          { model: 'paragraph',  title: 'Paragraph' },
          { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
          { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
        ]
      }
    })
    .then(function (editor) {
      input.closest('form').addEventListener('submit', function () {
        input.value = editor.getData();
      });
    })
    .catch(function (err) {
      console.error('CKEditor failed to load:', err);
    });
})();
</script>
@endpush
