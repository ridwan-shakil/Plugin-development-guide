
---

## 14. Meta Boxes (Admin UI for Metadata)

Meta Boxes are used to **collect and display metadata in the WordPress admin** (post edit screen).

They are only a **UI layer** — actual data storage still uses the Metadata API.

---

## 15. When to Use Meta Boxes

Use Meta Boxes when:

* Admins need to input/edit meta manually
* Data is post-specific
* Custom Fields UI is not sufficient

Do **not** use Meta Boxes for:

* Global settings (use Options API)
* Complex datasets (consider custom tables)

---

## 16. Registering a Meta Box

Meta boxes are registered using the `add_meta_boxes` hook.

```php
add_action( 'add_meta_boxes', 'rsob_register_order_meta_box' );

function rsob_register_order_meta_box() {
    add_meta_box(
        'rsob_order_note',
        __( 'Order Note', 'rsob' ),
        'rsob_render_order_meta_box',
        'shop_order',
        'side',
        'default'
    );
}
```

---

## 17. Rendering a Meta Box (Best Practices)

```php
function rsob_render_order_meta_box( $post ) {
    wp_nonce_field( 'rsob_save_order_note', 'rsob_order_note_nonce' );

    $value = get_post_meta( $post->ID, 'rsob_order_note', true );
    ?>
    <input
        type="text"
        name="rsob_order_note"
        value="<?php echo esc_attr( $value ); ?>"
        class="widefat"
    />
    <?php
}
```

Best practices:

* Always add a nonce
* Escape output (`esc_attr`, `esc_html`)
* Never save data here

---

## 18. Saving Meta Box Data (Save Hooks)

Meta box data is saved using the `save_post` hook.

```php
add_action( 'save_post', 'rsob_save_order_note_meta' );

function rsob_save_order_note_meta( $post_id ) {
    if ( ! isset( $_POST['rsob_order_note_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['rsob_order_note_nonce'], 'rsob_save_order_note' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['rsob_order_note'] ) ) {
        update_post_meta(
            $post_id,
            'rsob_order_note',
            sanitize_text_field( $_POST['rsob_order_note'] )
        );
    }
}
```

---

## 19. Mandatory Save Checklist (Never Skip)

Before saving meta, always check:

* Nonce exists
* Nonce is valid
* Not an autosave
* User has permission
* Data is sanitized

Skipping any of these may cause:

* Security issues
* Data corruption
* WordPress.org rejection

---

## 20. OOP Pattern for Meta Boxes (Recommended)

In plugins, meta boxes should be encapsulated in a class.

```php
class RSOB_Order_Meta_Box {

    public function register() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save' ) );
    }

    public function add_meta_box() {
        add_meta_box(
            'rsob_order_note',
            __( 'Order Note', 'rsob' ),
            array( $this, 'render' ),
            'shop_order'
        );
    }

    public function render( $post ) {
        wp_nonce_field( 'rsob_save_order_note', 'rsob_order_note_nonce' );
        $value = get_post_meta( $post->ID, 'rsob_order_note', true );
        echo '<input type="text" class="widefat" name="rsob_order_note" value="' . esc_attr( $value ) . '" />';
    }

    public function save( $post_id ) {
        // same save checks as above
    }
}
```

---

## 21. Interview-Ready Summary (Meta Boxes)

> “Meta boxes provide an admin UI for editing post metadata. They should only render fields, while saving is handled via `save_post` with proper nonce, autosave, and capability checks. The actual storage is done using the Metadata API.”

---

**End of Notes**
