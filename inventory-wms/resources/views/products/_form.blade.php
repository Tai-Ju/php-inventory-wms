@csrf
<label>料號 SKU
    <input name="sku" value="{{ old('sku', $product->sku ?? '') }}" required>
</label>
@error('sku')<small class="err">{{ $message }}</small>@enderror

<label>品名
    <input name="name" value="{{ old('name', $product->name ?? '') }}" required>
</label>
@error('name')<small class="err">{{ $message }}</small>@enderror

<label>單位
    <input name="unit" value="{{ old('unit', $product->unit ?? 'pcs') }}" required>
</label>
@error('unit')<small class="err">{{ $message }}</small>@enderror

<label>安全庫存（低於此數量會提醒）
    <input type="number" min="0" name="safety_stock" value="{{ old('safety_stock', $product->safety_stock ?? 10) }}" required>
</label>
@error('safety_stock')<small class="err">{{ $message }}</small>@enderror

<label>儲位
    <input name="location" value="{{ old('location', $product->location ?? '') }}" placeholder="例如 A-01-02">
</label>

<label>備註
    <textarea name="notes" rows="3">{{ old('notes', $product->notes ?? '') }}</textarea>
</label>
