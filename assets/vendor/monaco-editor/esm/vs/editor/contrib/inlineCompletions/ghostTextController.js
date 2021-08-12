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
import { Disposable, MutableDisposable, toDisposable } from '../../../base/common/lifecycle.js';
import { EditorAction, EditorCommand, registerEditorAction, registerEditorCommand, registerEditorContribution } from '../../browser/editorExtensions.js';
import { EditorContextKeys } from '../../common/editorContextKeys.js';
import { GhostTextWidget } from './ghostTextWidget.js';
import * as nls from '../../../nls.js';
import { ContextKeyExpr, IContextKeyService, RawContextKey } from '../../../platform/contextkey/common/contextkey.js';
import { IInstantiationService } from '../../../platform/instantiation/common/instantiation.js';
import { GhostTextModel } from './ghostTextModel.js';
let GhostTextController = class GhostTextController extends Disposable {
    constructor(editor, instantiationService) {
        super();
        this.editor = editor;
        this.instantiationService = instantiationService;
        this.triggeredExplicitly = false;
        this.activeController = this._register(new MutableDisposable());
        this._register(this.editor.onDidChangeModel(() => {
            this.updateModelController();
        }));
        this._register(this.editor.onDidChangeConfiguration((e) => {
            if (e.hasChanged(104 /* suggest */)) {
                this.updateModelController();
            }
            if (e.hasChanged(52 /* inlineSuggest */)) {
                this.updateModelController();
            }
        }));
        this.updateModelController();
    }
    static get(editor) {
        return editor.getContribution(GhostTextController.ID);
    }
    get activeModel() {
        var _a;
        return (_a = this.activeController.value) === null || _a === void 0 ? void 0 : _a.model;
    }
    // Don't call this method when not neccessary. It will recreate the activeController.
    updateModelController() {
        const suggestOptions = this.editor.getOption(104 /* suggest */);
        const inlineSuggestOptions = this.editor.getOption(52 /* inlineSuggest */);
        this.activeController.value = undefined;
        // ActiveGhostTextController is only created if one of those settings is set or if the inline completions are triggered explicitly.
        this.activeController.value =
            this.editor.hasModel() && (suggestOptions.preview || inlineSuggestOptions.enabled || this.triggeredExplicitly)
                ? this.instantiationService.createInstance(ActiveGhostTextController, this.editor)
                : undefined;
    }
    shouldShowHoverAt(hoverRange) {
        var _a;
        return ((_a = this.activeModel) === null || _a === void 0 ? void 0 : _a.shouldShowHoverAt(hoverRange)) || false;
    }
    shouldShowHoverAtViewZone(viewZoneId) {
        var _a, _b;
        return ((_b = (_a = this.activeController.value) === null || _a === void 0 ? void 0 : _a.widget) === null || _b === void 0 ? void 0 : _b.shouldShowHoverAtViewZone(viewZoneId)) || false;
    }
    trigger() {
        var _a;
        this.triggeredExplicitly = true;
        if (!this.activeController.value) {
            this.updateModelController();
        }
        (_a = this.activeModel) === null || _a === void 0 ? void 0 : _a.triggerInlineCompletion();
    }
    commit() {
        var _a;
        (_a = this.activeModel) === null || _a === void 0 ? void 0 : _a.commitInlineCompletion();
    }
    hide() {
        var _a;
        (_a = this.activeModel) === null || _a === void 0 ? void 0 : _a.hideInlineCompletion();
    }
    showNextInlineCompletion() {
        var _a;
        (_a = this.activeModel) === null || _a === void 0 ? void 0 : _a.showNextInlineCompletion();
    }
    showPreviousInlineCompletion() {
        var _a;
        (_a = this.activeModel) === null || _a === void 0 ? void 0 : _a.showPreviousInlineCompletion();
    }
    hasMultipleInlineCompletions() {
        var _a;
        return __awaiter(this, void 0, void 0, function* () {
            const result = yield ((_a = this.activeModel) === null || _a === void 0 ? void 0 : _a.hasMultipleInlineCompletions());
            return result !== undefined ? result : false;
        });
    }
};
GhostTextController.inlineSuggestionVisible = new RawContextKey('inlineSuggestionVisible', false, nls.localize('inlineSuggestionVisible', "Whether an inline suggestion is visible"));
GhostTextController.inlineSuggestionHasIndentation = new RawContextKey('inlineSuggestionHasIndentation', false, nls.localize('inlineSuggestionHasIndentation', "Whether the inline suggestion starts with whitespace"));
GhostTextController.ID = 'editor.contrib.ghostTextController';
GhostTextController = __decorate([
    __param(1, IInstantiationService)
], GhostTextController);
export { GhostTextController };
class GhostTextContextKeys {
    constructor(contextKeyService) {
        this.contextKeyService = contextKeyService;
        this.inlineCompletionVisible = GhostTextController.inlineSuggestionVisible.bindTo(this.contextKeyService);
        this.inlineCompletionSuggestsIndentation = GhostTextController.inlineSuggestionHasIndentation.bindTo(this.contextKeyService);
    }
}
/**
 * The controller for a text editor with an initialized text model.
 * Must be disposed as soon as the model detaches from the editor.
*/
let ActiveGhostTextController = class ActiveGhostTextController extends Disposable {
    constructor(editor, instantiationService, contextKeyService) {
        super();
        this.editor = editor;
        this.instantiationService = instantiationService;
        this.contextKeyService = contextKeyService;
        this.contextKeys = new GhostTextContextKeys(this.contextKeyService);
        this.model = this._register(this.instantiationService.createInstance(GhostTextModel, this.editor));
        this.widget = this._register(this.instantiationService.createInstance(GhostTextWidget, this.editor, this.model));
        this._register(toDisposable(() => {
            this.contextKeys.inlineCompletionVisible.set(false);
            this.contextKeys.inlineCompletionSuggestsIndentation.set(false);
        }));
        this._register(this.model.onDidChange(() => {
            this.updateContextKeys();
        }));
        this.updateContextKeys();
    }
    updateContextKeys() {
        var _a;
        this.contextKeys.inlineCompletionVisible.set(((_a = this.model.activeInlineCompletionsModel) === null || _a === void 0 ? void 0 : _a.ghostText) !== undefined);
        const ghostText = this.model.inlineCompletionsModel.ghostText;
        if (ghostText && ghostText.parts.length > 0) {
            const { column, lines } = ghostText.parts[0];
            const suggestionStartsWithWs = lines[0].startsWith(' ') || lines[0].startsWith('\t');
            const indentationEndColumn = this.editor.getModel().getLineIndentColumn(ghostText.lineNumber);
            const inIndentation = column <= indentationEndColumn;
            this.contextKeys.inlineCompletionSuggestsIndentation.set(!!this.model.activeInlineCompletionsModel
                && suggestionStartsWithWs && inIndentation);
        }
        else {
            this.contextKeys.inlineCompletionSuggestsIndentation.set(false);
        }
    }
};
ActiveGhostTextController = __decorate([
    __param(1, IInstantiationService),
    __param(2, IContextKeyService)
], ActiveGhostTextController);
export { ActiveGhostTextController };
const GhostTextCommand = EditorCommand.bindToContribution(GhostTextController.get);
export const commitInlineSuggestionAction = new GhostTextCommand({
    id: 'editor.action.inlineSuggest.commit',
    precondition: ContextKeyExpr.and(GhostTextController.inlineSuggestionVisible, GhostTextController.inlineSuggestionHasIndentation.toNegated(), EditorContextKeys.tabMovesFocus.toNegated()),
    kbOpts: {
        weight: 200,
        primary: 2 /* Tab */,
    },
    handler(x) {
        x.commit();
        x.editor.focus();
    }
});
registerEditorCommand(commitInlineSuggestionAction);
registerEditorCommand(new GhostTextCommand({
    id: 'editor.action.inlineSuggest.hide',
    precondition: GhostTextController.inlineSuggestionVisible,
    kbOpts: {
        weight: 100,
        primary: 9 /* Escape */,
    },
    handler(x) {
        x.hide();
    }
}));
export class ShowNextInlineSuggestionAction extends EditorAction {
    constructor() {
        super({
            id: ShowNextInlineSuggestionAction.ID,
            label: nls.localize('action.inlineSuggest.showNext', "Show Next Inline Suggestion"),
            alias: 'Show Next Inline Suggestion',
            precondition: ContextKeyExpr.and(EditorContextKeys.writable, GhostTextController.inlineSuggestionVisible),
            kbOpts: {
                weight: 100,
                primary: 512 /* Alt */ | 89 /* US_CLOSE_SQUARE_BRACKET */,
            },
        });
    }
    run(accessor, editor) {
        return __awaiter(this, void 0, void 0, function* () {
            const controller = GhostTextController.get(editor);
            if (controller) {
                controller.showNextInlineCompletion();
                editor.focus();
            }
        });
    }
}
ShowNextInlineSuggestionAction.ID = 'editor.action.inlineSuggest.showNext';
export class ShowPreviousInlineSuggestionAction extends EditorAction {
    constructor() {
        super({
            id: ShowPreviousInlineSuggestionAction.ID,
            label: nls.localize('action.inlineSuggest.showPrevious', "Show Previous Inline Suggestion"),
            alias: 'Show Previous Inline Suggestion',
            precondition: ContextKeyExpr.and(EditorContextKeys.writable, GhostTextController.inlineSuggestionVisible),
            kbOpts: {
                weight: 100,
                primary: 512 /* Alt */ | 87 /* US_OPEN_SQUARE_BRACKET */,
            },
        });
    }
    run(accessor, editor) {
        return __awaiter(this, void 0, void 0, function* () {
            const controller = GhostTextController.get(editor);
            if (controller) {
                controller.showPreviousInlineCompletion();
                editor.focus();
            }
        });
    }
}
ShowPreviousInlineSuggestionAction.ID = 'editor.action.inlineSuggest.showPrevious';
export class TriggerInlineSuggestionAction extends EditorAction {
    constructor() {
        super({
            id: 'editor.action.inlineSuggest.trigger',
            label: nls.localize('action.inlineSuggest.trigger', "Trigger Inline Suggestion"),
            alias: 'Trigger Inline Suggestion',
            precondition: EditorContextKeys.writable
        });
    }
    run(accessor, editor) {
        return __awaiter(this, void 0, void 0, function* () {
            const controller = GhostTextController.get(editor);
            if (controller) {
                controller.trigger();
            }
        });
    }
}
registerEditorContribution(GhostTextController.ID, GhostTextController);
registerEditorAction(TriggerInlineSuggestionAction);
registerEditorAction(ShowNextInlineSuggestionAction);
registerEditorAction(ShowPreviousInlineSuggestionAction);
