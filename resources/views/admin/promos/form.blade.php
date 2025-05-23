<div class="mb-3">
    <label>Code</label>
    <input type="text" name="code" class="form-control" value="{{ old('code', $promo->code ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Réduction (€ ou % selon usage)</label>
    <input type="number" step="0.01" name="discount" class="form-control" value="{{ old('discount', $promo->discount ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Date d'expiration</label>
    <input type="date" name="expires_at" class="form-control" value="{{ old('expires_at', optional($promo->expires_at ?? null)->format('Y-m-d')) }}">
</div>

<div class="mb-3">
    <label>Limite d'utilisation</label>
    <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $promo->usage_limit ?? '') }}">
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="active" value="1"
        {{ old('active', $promo->active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label">Actif</label>
</div>
