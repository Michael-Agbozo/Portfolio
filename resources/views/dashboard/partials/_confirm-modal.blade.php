{{-- Reusable confirm dialog for delete actions — replaces the browser's plain confirm() popup.
     Use on a form: onsubmit="return confirmDelete(event, this, 'Delete this project? This cannot be undone.')" --}}
<div id="confirm-overlay" class="confirm-overlay">
  <div class="confirm-box">
    <div class="confirm-icon">!</div>
    <div class="confirm-title" id="confirm-title">Are you sure?</div>
    <p class="confirm-message" id="confirm-message"></p>
    <div class="confirm-actions">
      <button type="button" class="btn btn-secondary btn-sm" onclick="closeConfirmModal()">Cancel</button>
      <button type="button" class="btn btn-danger btn-sm" id="confirm-ok-btn">Yes, Delete</button>
    </div>
  </div>
</div>

@once
@push('scripts')
<script>
  let confirmModalForm = null;

  function confirmDelete(event, form, message, title) {
    event.preventDefault();
    confirmModalForm = form;
    document.getElementById('confirm-title').textContent = title || 'Are you sure?';
    document.getElementById('confirm-message').textContent = message;
    document.getElementById('confirm-overlay').classList.add('is-open');
    return false;
  }

  function closeConfirmModal() {
    document.getElementById('confirm-overlay').classList.remove('is-open');
    confirmModalForm = null;
  }

  let confirmSubmitting = false;
  document.getElementById('confirm-ok-btn').addEventListener('click', function () {
    if (confirmSubmitting) return; // ignore a second click while the first is going through
    const form = confirmModalForm;
    if (!form) return;
    confirmSubmitting = true;
    this.disabled = true;
    this.textContent = 'Please wait…';
    closeConfirmModal();
    form.submit(); // bypasses the form's own submit handlers/validation — fires the request exactly once
  });
  document.getElementById('confirm-overlay').addEventListener('click', (e) => {
    if (e.target.id === 'confirm-overlay') closeConfirmModal();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeConfirmModal();
  });
</script>
@endpush
@endonce
