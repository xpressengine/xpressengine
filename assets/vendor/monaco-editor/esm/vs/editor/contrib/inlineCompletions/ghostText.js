/*---------------------------------------------------------------------------------------------
 *  Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
import { Emitter } from '../../../base/common/event.js';
import { Disposable } from '../../../base/common/lifecycle.js';
export class GhostText {
    constructor(lineNumber, parts, additionalReservedLineCount = 0) {
        this.lineNumber = lineNumber;
        this.parts = parts;
        this.additionalReservedLineCount = additionalReservedLineCount;
    }
}
export class BaseGhostTextWidgetModel extends Disposable {
    constructor(editor) {
        super();
        this.editor = editor;
        this._expanded = undefined;
        this.onDidChangeEmitter = new Emitter();
        this.onDidChange = this.onDidChangeEmitter.event;
        this._register(editor.onDidChangeConfiguration((e) => {
            if (e.hasChanged(104 /* suggest */) && this._expanded === undefined) {
                this.onDidChangeEmitter.fire();
            }
        }));
    }
    get expanded() {
        if (this._expanded === undefined) {
            // TODO this should use a global hidden setting.
            // See https://github.com/microsoft/vscode/issues/125037.
            return true;
        }
        return this._expanded;
    }
    setExpanded(expanded) {
        this._expanded = true;
        this.onDidChangeEmitter.fire();
    }
}
