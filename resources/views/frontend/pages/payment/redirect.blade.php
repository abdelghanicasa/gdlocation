<form id="sogecommerceForm" method="POST" action="https://sogecommerce.societegenerale.eu/vads-payment/">
    @foreach($fields as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach
</form>

<script>
    document.getElementById('sogecommerceForm').submit();
</script>
