<input 
    class="{{ $class }}" 
    type="{{ $type }}" 
    name="{{ $name }}" 
    {{ $id ? 'id="'.$id.'"' : ''}}
    placeholder="{{ $placeholder }}" 
    {{ $required ? 'required' : '' }}
    {{ $autofocus ? 'autofocus' : '' }}
    value="{{ $value }}"
>