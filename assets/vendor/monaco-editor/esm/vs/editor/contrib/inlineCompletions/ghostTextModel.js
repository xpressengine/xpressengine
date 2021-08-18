/*---------------------------------------------------------------------------------------------
 *  Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
import { Disposable, MutableDisposable } from '../../../base/common/lifecycle.js';
import { InlineCompletionsModel } from './inlineCompletionsModel.js';
import { SuggestWidgetAdapterModel } from './suggestWidgetAdapterModel.js';
import { ICommandService } from '../../../platform/commands/common/commands.js';
import { Emitter } from '../../../base/common/event.js';
import { Position } from '../../common/core/position.js';
import { createDisposableRef } from './utils.js';
export class DelegatingModel extends Disposable {
    constructor() {
        super(...arguments);
        this.onDidChangeEmitter = new Emitter();
        this.onDidChange = this.onDidChangeEmitter.event;
        this.hasCachedGhostText = false;
        this.currentModelRef = this._register(new MutableDisposable());
    }
    get targetModel() {
        var _a;
        return (_a = this.currentModelRef.value) === null || _a === void 0 ? void 0 : _a.object;
    }
    setTargetModel(model) {
        this.currentModelRef.clear();
        this.currentModelRef.value = model ? createDisposableRef(model, model.onDidChange(() => {
            this.hasCachedGhostText = false;
            this.onDidChangeEmitter.fire();
        })) : undefined;
        this.hasCachedGhostText = false;
        this.onDidChangeEmitter.fire();
    }
    get ghostText() {
        var _a, _b;
        if (!this.hasCachedGhostText) {
            this.cachedGhostText = (_b = (_a = this.currentModelRef.value) === null || _a === void 0 ? void 0 : _a.object) === null || _b === void 0 ? void 0 : _b.ghostText;
            this.hasCachedGhostText = true;
        }
        return this.cachedGhostText;
    }
    setExpanded(expanded) {
        var _a;
        (_a = this.targetModel) === null || _a === void 0 ? void 0 : _a.setExpanded(expanded);
    }
    get expanded() {
        return this.targetModel ? this.targetModel.expanded : false;
    }
    get minReservedLineCount() {
        return this.targetModel ? this.targetModel.minReservedLineCount : 0;
    }
}
/**
 * A ghost text model that is both driven by inline completions and the suggest widget.
*/
let GhostTextModel = class GhostTextModel extends DelegatingModel {
    constructor(editor, commandService) {
        super();
        this.editor = editor;
        this.commandService = commandService;
        this.suggestWidgetAdapterModel = this._register(new SuggestWidgetAdapterModel(this.editor));
        this.inlineCompletionsModel = this._register(new InlineCompletionsModel(this.editor, this.commandService));
        this._register(this.suggestWidgetAdapterModel.onDidChange(() => {
            this.updateModel();
        }));
        this.updateModel();
    }
    get activeInlineCompletionsModel() {
        if (this.targetModel === this.inlineCompletionsModel) {
            return this.inlineCompletionsModel;
        }
        return undefined;
    }
    updateModel() {
        this.setTargetModel(this.suggestWidgetAdapterModel.isActive
            ? this.suggestWidgetAdapterModel
            : this.inlineCompletionsModel);
        this.inlineCompletionsModel.setActive(this.targetModel === this.inlineCompletionsModel);
    }
    shouldShowHoverAt(hoverRange) {
        var _a;
        const ghostText = (_a = this.activeInlineCompletionsModel) === null || _a === void 0 ? void 0 : _a.ghostText;
        if (ghostText) {
            return ghostText.parts.some(p => hoverRange.containsPosition(new Position(ghostText.lineNumber, p.column)));
        }
        return false;
    }
    triggerInlineCompletion() {
        var _a;
        (_a = this.activeInlineCompletionsModel) === null || _a === void 0 ? void 0 : _a.trigger();
    }
    commitInlineCompletion() {
        var _a;
        (_a = this.activeInlineCompletionsModel) === null || _a === void 0 ? void 0 : _a.commitCurrentSuggestion();
    }
    hideInlineCompletion() {
        var _a;
        (_a = this.activeInlineCompletionsModel) === null || _a === void 0 ? void 0 : _a.hide();
    }
    showNextInlineCompletion() {
        var _a;
        (_a = this.activeInlineCompletionsModel) === null || _a === void 0 ? void 0 : _a.showNext();
    }
    showPreviousInlineCompletion() {
        var _a;
        (_a = this.activeInlineCompletionsModel) === null || _a === void 0 ? void 0 : _a.showPrevious();
    }
    hasMultipleInlineCompletions() {
        var _a;
        return __awaiter(this, void 0, void 0, function* () {
            const result = yield ((_a = this.activeInlineCompletionsModel) === null || _a === void 0 ? void 0 : _a.hasMultipleInlineCompletions());
            return result !== undefined ? result : false;
        });
    }
};
GhostTextModel = __decorate([
    __param(1, ICommandService)
], GhostTextModel);
export { GhostTextModel };
