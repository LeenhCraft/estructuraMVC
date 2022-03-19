<?php headerWeb($data); ?>
<div class="container">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus tenetur ab, ullam totam commodi recusandae laboriosam incidunt autem. Ducimus praesentium culpa neque. Fuga ipsam beatae officia aliquid ipsa eius incidunt.</p>

</div>
<?php
enviarEmail(['email' => 'hackingleenh@gmail.com', 'asunto' => 'prueba'], 'email');
footerWeb($data); ?>