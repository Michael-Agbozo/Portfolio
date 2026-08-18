@php
  $caseProject = $project ?? null;
  $servicesValue = old('services', implode(', ', $caseProject->services ?? []));
  $techStackValue = old('tech_stack', implode(', ', $caseProject->tech_stack ?? []));
  $beforeImage = old('before_image', $caseProject->before_image ?? '');
  $afterImage = old('after_image', $caseProject->after_image ?? '');
@endphp

<div class="form-section-label" style="margin-top:2rem">Case Study Details</div>

<div class="form-grid-2">
  <div class="form-group">
    <label class="f-label">Client / Brand Name</label>
    <input class="f-input {{ $errors->has('client_name') ? 'is-error' : '' }}" type="text" name="client_name" value="{{ old('client_name', $caseProject->client_name ?? '') }}" placeholder="Client or brand name"/>
    @error('client_name')<div class="field-error">{{ $message }}</div>@enderror
  </div>
  <div class="form-group">
    <label class="f-label">Project Year</label>
    <input class="f-input {{ $errors->has('project_year') ? 'is-error' : '' }}" type="text" name="project_year" value="{{ old('project_year', $caseProject->project_year ?? '') }}" placeholder="2026"/>
    @error('project_year')<div class="field-error">{{ $message }}</div>@enderror
  </div>
</div>

<div class="form-group">
  <label class="f-label">Services Used</label>
  <input class="f-input {{ $errors->has('services') ? 'is-error' : '' }}" type="text" name="services" value="{{ $servicesValue }}" placeholder="Web Design, Laravel, Brand Identity"/>
  <div class="f-hint">Separate services with commas</div>
  @error('services')<div class="field-error">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label class="f-label">Tech Stack</label>
  <input class="f-input {{ $errors->has('tech_stack') ? 'is-error' : '' }}" type="text" name="tech_stack" value="{{ $techStackValue }}" placeholder="Laravel, WordPress, Tailwind, Figma"/>
  <div class="f-hint">Separate tools or technologies with commas</div>
  @error('tech_stack')<div class="field-error">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label class="f-label">The Challenge</label>
  <textarea class="f-textarea {{ $errors->has('challenge') ? 'is-error' : '' }}" name="challenge" placeholder="What problem did the client or project have?">{{ old('challenge', $caseProject->challenge ?? '') }}</textarea>
  @error('challenge')<div class="field-error">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label class="f-label">The Solution</label>
  <textarea class="f-textarea {{ $errors->has('solution') ? 'is-error' : '' }}" name="solution" placeholder="What did you design, build, fix, or improve?">{{ old('solution', $caseProject->solution ?? '') }}</textarea>
  @error('solution')<div class="field-error">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label class="f-label">Results / Outcome</label>
  <textarea class="f-textarea {{ $errors->has('results') ? 'is-error' : '' }}" name="results" placeholder="What changed after the work was done?">{{ old('results', $caseProject->results ?? '') }}</textarea>
  @error('results')<div class="field-error">{{ $message }}</div>@enderror
</div>

<div class="form-group">
  <label class="f-label">Client Testimonial</label>
  <textarea class="f-textarea {{ $errors->has('testimonial') ? 'is-error' : '' }}" name="testimonial" placeholder="Optional client quote">{{ old('testimonial', $caseProject->testimonial ?? '') }}</textarea>
  @error('testimonial')<div class="field-error">{{ $message }}</div>@enderror
</div>

<div class="form-grid-2">
  <div class="form-group">
    <label class="f-label">Before Image</label>
    <input class="f-input {{ $errors->has('before_image') ? 'is-error' : '' }}" type="text" name="before_image" id="before-image-path" value="{{ $beforeImage }}" placeholder="/storage/projects/before.jpg"/>
    <div style="display:flex;gap:.6rem;flex-wrap:wrap;margin-top:.6rem">
      <button type="button" class="btn btn-secondary btn-sm" onclick="openMediaPicker('before')">Choose from Library</button>
      <button type="button" class="btn btn-secondary btn-sm" onclick="setBeforeImageFromPath('')">Clear</button>
    </div>
    @error('before_image')<div class="field-error">{{ $message }}</div>@enderror
  </div>
  <div class="form-group">
    <label class="f-label">After Image</label>
    <input class="f-input {{ $errors->has('after_image') ? 'is-error' : '' }}" type="text" name="after_image" id="after-image-path" value="{{ $afterImage }}" placeholder="/storage/projects/after.jpg"/>
    <div style="display:flex;gap:.6rem;flex-wrap:wrap;margin-top:.6rem">
      <button type="button" class="btn btn-secondary btn-sm" onclick="openMediaPicker('after')">Choose from Library</button>
      <button type="button" class="btn btn-secondary btn-sm" onclick="setAfterImageFromPath('')">Clear</button>
    </div>
    @error('after_image')<div class="field-error">{{ $message }}</div>@enderror
  </div>
</div>

@push('scripts')
<script>
function setBeforeImageFromPath(path) {
  document.getElementById('before-image-path').value = path;
}

function setAfterImageFromPath(path) {
  document.getElementById('after-image-path').value = path;
}
</script>
@endpush
