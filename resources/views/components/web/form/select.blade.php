<select 
    class="{{ $class }}" 
    name="{{ $name }}" 
    id="{{ $id }}">
    {{ $slot ?? ''}}
</select>