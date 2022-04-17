/*---------------------------------------------------------------------------------------------
 *  Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
import './hover.css';
import * as dom from '../../dom.js';
import { Disposable } from '../../../common/lifecycle.js';
import { DomScrollableElement } from '../scrollbar/scrollableElement.js';
const $ = dom.$;
export class HoverWidget extends Disposable {
    constructor() {
        super();
        this.containerDomNode = document.createElement('div');
        this.containerDomNode.className = 'monaco-hover';
        this.containerDomNode.tabIndex = 0;
        this.containerDomNode.setAttribute('role', 'tooltip');
        this.contentsDomNode = document.createElement('div');
        this.contentsDomNode.className = 'monaco-hover-content';
        this._scrollbar = this._register(new DomScrollableElement(this.contentsDomNode, {
            consumeMouseWheelIfScrollbarIsNeeded: true
        }));
        this.containerDomNode.appendChild(this._scrollbar.getDomNode());
    }
    onContentsChanged() {
        this._scrollbar.scanDomNode();
    }
}
export class HoverAction extends Disposable {
    constructor(parent, actionOptions, keybindingLabel) {
        super();
        this.actionContainer = dom.append(parent, $('div.action-container'));
        this.action = dom.append(this.actionContainer, $('a.action'));
        this.action.setAttribute('href', '#');
        this.action.setAttribute('role', 'button');
        if (actionOptions.iconClass) {
            dom.append(this.action, $(`span.icon.${actionOptions.iconClass}`));
        }
        const label = dom.append(this.action, $('span'));
        label.textContent = keybindingLabel ? `${actionOptions.label} (${keybindingLabel})` : actionOptions.label;
        this._register(dom.addDisposableListener(this.actionContainer, dom.EventType.CLICK, e => {
            e.stopPropagation();
            e.preventDefault();
            actionOptions.run(this.actionContainer);
        }));
        this.setEnabled(true);
    }
    static render(parent, actionOptions, keybindingLabel) {
        return new HoverAction(parent, actionOptions, keybindingLabel);
    }
    setEnabled(enabled) {
        if (enabled) {
            this.actionContainer.classList.remove('disabled');
            this.actionContainer.removeAttribute('aria-disabled');
        }
        else {
            this.actionContainer.classList.add('disabled');
            this.actionContainer.setAttribute('aria-disabled', 'true');
        }
    }
}
