<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
/*
fix1653731540-entidades-mb-inc.php
*/

class Fix1653735709 {
	private $config = '{
		"title":"Dados",
		"description":"Campos adicionais pertencente a cada post",
		"prefix":"fix1653735735",
		"domain":"fix1653735757",
		"class_name":"Fix1653735709",
		"context":"normal",
		"priority":"default",
		"cpt":"entidades",
		"fields":[
			{
				"type":"text",
				"label":"Usuario ID",
				"id":"fix1653735805_usuario_id"
			},{
				"type":"text",
				"label":"Nome",
				"id":"fix1653735805_nome"
			},{
				"type":"text",
				"label":"CPF/CNPJ",
				"id":"fix1653735805_cpf_cnpj"
			},

			{
				"type":"text",
				"label":"E-mail",
				"id":"fix1653750796_email"
			},{
				"type":"text",
				"label":"CEP",
				"id":"fix1653750796_cep"
			},{
				"type":"text",
				"label":"Logradouro",
				"id":"fix1653750796_logradouro"
			},{
				"type":"text",
				"label":"Número",
				"id":"fix1653750796_logradouro_numero"
			},{
				"type":"text",
				"label":"Complemento",
				"id":"fix1653750796_logradouro_complemento"
			},{
				"type":"text",
				"label":"Bairro",
				"id":"fix1653750796_logradouro_bairro"
			},{
				"type":"text",
				"label":"Cidade",
				"id":"fix1653750796_logradouro_cidade"
			},{
				"type":"text",
				"label":"UF",
				"id":"fix1653750796_logradouro_uf"
			},{
				"type":"text",
				"label":"Telefone fixo",
				"id":"fix1653750796_telefone_fixo"
			},{
				"type":"text",
				"label":"Celular",
				"id":"fix1653750796_celular"
			}			

		]
	}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		$this->process_cpts();
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'admin_head', [ $this, 'admin_head' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );
	}

	public function process_cpts() {
		if ( !empty( $this->config['cpt'] ) ) {
			if ( empty( $this->config['post-type'] ) ) {
				$this->config['post-type'] = [];
			}
			$parts = explode( ',', $this->config['cpt'] );
			$parts = array_map( 'trim', $parts );
			$this->config['post-type'] = array_merge( $this->config['post-type'], $parts );
		}
	}

	public function add_meta_boxes() {
		foreach ( $this->config['post-type'] as $screen ) {
			add_meta_box(
				sanitize_title( $this->config['title'] ),
				$this->config['title'],
				[ $this, 'add_meta_box_callback' ],
				$screen,
				$this->config['context'],
				$this->config['priority']
			);
		}
	}

	public function admin_head() {
		global $typenow;
		if ( in_array( $typenow, $this->config['post-type'] ) ) {
			?><?php
		}
	}

	public function save_post( $post_id ) {
		foreach ( $this->config['fields'] as $field ) {
			switch ( $field['type'] ) {
				default:
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
			}
		}
	}

	public function add_meta_box_callback() {
		echo '<div class="rwp-description">' . $this->config['description'] . '</div>';
		$this->fields_table();
	}

	private function fields_table() {
		?><table class="form-table" role="presentation">
			<tbody><?php
				foreach ( $this->config['fields'] as $field ) {
					?><tr>
						<th scope="row"><?php $this->label( $field ); ?></th>
						<td><?php $this->field( $field ); ?>


					--- 
					<?php 
					// $info = isset($this->field['info']);
					// echo $info; 

					// print_r($field);
					// echo $this->value( $field );
					?> 

				</td>

					</tr><?php
				}
			?></tbody>
		</table><?php
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			default:
				printf(
					'<label class="" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			default:
				$this->input( $field );
		}
	}

	private function input( $field ) {
		printf(
			'<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s" autocomplete="off">',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )

		);
		// echo 'ggggg-'; =================
		$info = isset( $field['info'] ) ? $field['info'] : '';
		if($info){
			$info = preg_replace("/__user_id__/", $this->value( $field ), $info);
			$info = preg_replace("/__site_url__/", site_url(), $info);
			
			// echo $this->value( $field );
			echo $info;
		}
		// echo '-ggggg';
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = $field['default'];
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}
	private function info( $field ) {
		return "zzz";
	}

}
new Fix1653735709;
