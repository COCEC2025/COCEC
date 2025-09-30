{{-- Champ honeypot pour détecter les bots --}}
<div style="position: absolute; left: -9999px; top: -9999px; opacity: 0; visibility: hidden;">
    <label for="website_url">Site web (ne pas remplir)</label>
    <input type="text" 
           id="website_url" 
           name="website_url" 
           tabindex="-1" 
           autocomplete="off"
           value="">
</div>

{{-- Champ honeypot alternatif --}}
<div style="position: absolute; left: -9999px; top: -9999px; opacity: 0; visibility: hidden;">
    <label for="phone_number">Téléphone (ne pas remplir)</label>
    <input type="tel" 
           id="phone_number" 
           name="phone_number" 
           tabindex="-1" 
           autocomplete="off"
           value="">
</div>
