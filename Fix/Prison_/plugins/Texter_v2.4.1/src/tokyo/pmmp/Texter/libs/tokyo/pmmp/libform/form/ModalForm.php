<?php

/**
 * // English
 *
 * libform is a library for PocketMine-MP for easy operation of forms
 * Copyright (c) 2018 yuko fuyutsuki < https://github.com/fuyutsuki >
 *
 * This software is distributed under "MIT license".
 * You should have received a copy of the MIT license
 * along with this program.  If not, see
 * < https://opensource.org/licenses/mit-license >.
 *
 * ---------------------------------------------------------------------
 * // 日本語
 *
 * libformは、フォームを簡単に操作するためのpocketmine-MP向けライブラリです
 * Copyright (c) 2018 yuko fuyutsuki < https://github.com/fuyutsuki >
 *
 * このソフトウェアは"MITライセンス"下で配布されています。
 * あなたはこのプログラムと共にMITライセンスのコピーを受け取ったはずです。
 * 受け取っていない場合、下記のURLからご覧ください。
 * < https://opensource.org/licenses/mit-license >
 */

namespace tokyo\pmmp\Texter\libs\tokyo\pmmp\libform\form;

// libform
use tokyo\pmmp\Texter\libs\tokyo\pmmp\libform\{
  element\Element
};

/**
 * ModalFormClass
 */
class ModalForm extends Form {

  /** @var string */
  private const FORM_TYPE = "modal";
  /** @var array */
  protected $data = [
    Form::KEY_TYPE => self::FORM_TYPE,
    Form::KEY_TITLE => "",
    Form::KEY_CONTENT => "",
    Form::KEY_BUTTON1 => "",
    Form::KEY_BUTTON2 => ""
  ];

  public function setButtonText(bool $button, string $text): ModalForm {
    if ($button) {
      $this->data[Form::KEY_BUTTON1] = $text;
    }else {
      $this->data[Form::KEY_BUTTON2] = $text;
    }
    return $this;
  }

  public function getContents(): string {
    return $this->data[Form::KEY_CONTENT];
  }

  public function setContents(string $content): ModalForm {
    $this->data[Form::KEY_CONTENT] = $content;
    return $this;
  }
}
