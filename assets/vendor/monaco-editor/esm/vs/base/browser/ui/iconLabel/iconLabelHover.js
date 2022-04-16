/*---------------------------------------------------------------------------------------------
 *  Copyright (c) Microsoft Corporation. All rights reserved.
 *  Licensed under the MIT License. See License.txt in the project root for license information.
 *--------------------------------------------------------------------------------------------*/
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
import { isFunction, isString } from '../../../common/types.js';
import * as dom from '../../dom.js';
import { CancellationTokenSource } from '../../../common/cancellation.js';
import { toDisposable } from '../../../common/lifecycle.js';
import { localize } from '../../../../nls.js';
import { RunOnceScheduler } from '../../../common/async.js';
export function setupNativeHover(htmlElement, tooltip) {
    if (isString(tooltip)) {
        htmlElement.title = tooltip;
    }
    else if (tooltip === null || tooltip === void 0 ? void 0 : tooltip.markdownNotSupportedFallback) {
        htmlElement.title = tooltip.markdownNotSupportedFallback;
    }
    else {
        htmlElement.removeAttribute('title');
    }
}
export function setupCustomHover(hoverDelegate, htmlElement, markdownTooltip) {
    if (!markdownTooltip) {
        return undefined;
    }
    const tooltip = getTooltipForCustom(markdownTooltip);
    let hoverPreparation;
    let hoverWidget;
    const mouseEnter = (e) => {
        if (hoverPreparation) {
            return;
        }
        const tokenSource = new CancellationTokenSource();
        const mouseLeaveOrDown = (e) => {
            const isMouseDown = e.type === dom.EventType.MOUSE_DOWN;
            if (isMouseDown) {
                hoverWidget === null || hoverWidget === void 0 ? void 0 : hoverWidget.dispose();
                hoverWidget = undefined;
            }
            if (isMouseDown || e.fromElement === htmlElement) {
                hoverPreparation === null || hoverPreparation === void 0 ? void 0 : hoverPreparation.dispose();
                hoverPreparation = undefined;
            }
        };
        const mouseLeaveDomListener = dom.addDisposableListener(htmlElement, dom.EventType.MOUSE_LEAVE, mouseLeaveOrDown, true);
        const mouseDownDownListener = dom.addDisposableListener(htmlElement, dom.EventType.MOUSE_DOWN, mouseLeaveOrDown, true);
        const target = {
            targetElements: [htmlElement],
            dispose: () => { }
        };
        let mouseMoveDomListener;
        if (hoverDelegate.placement === undefined || hoverDelegate.placement === 'mouse') {
            const mouseMove = (e) => target.x = e.x + 10;
            mouseMoveDomListener = dom.addDisposableListener(htmlElement, dom.EventType.MOUSE_MOVE, mouseMove, true);
        }
        const showHover = () => __awaiter(this, void 0, void 0, function* () {
            var _a;
            if (hoverPreparation) {
                const hoverOptions = {
                    text: localize('iconLabel.loading', "Loading..."),
                    target,
                    hoverPosition: 2 /* BELOW */
                };
                hoverWidget === null || hoverWidget === void 0 ? void 0 : hoverWidget.dispose();
                hoverWidget = hoverDelegate.showHover(hoverOptions);
                const resolvedTooltip = (_a = (yield tooltip(tokenSource.token))) !== null && _a !== void 0 ? _a : (!isString(markdownTooltip) ? markdownTooltip.markdownNotSupportedFallback : undefined);
                hoverWidget === null || hoverWidget === void 0 ? void 0 : hoverWidget.dispose();
                hoverWidget = undefined;
                // awaiting the tooltip could take a while. Make sure we're still preparing to hover.
                if (resolvedTooltip && hoverPreparation) {
                    const hoverOptions = {
                        text: resolvedTooltip,
                        target,
                        showPointer: hoverDelegate.placement === 'element',
                        hoverPosition: 2 /* BELOW */
                    };
                    hoverWidget = hoverDelegate.showHover(hoverOptions);
                }
            }
            mouseMoveDomListener === null || mouseMoveDomListener === void 0 ? void 0 : mouseMoveDomListener.dispose();
        });
        const timeout = new RunOnceScheduler(showHover, hoverDelegate.delay);
        timeout.schedule();
        hoverPreparation = toDisposable(() => {
            timeout.dispose();
            mouseMoveDomListener === null || mouseMoveDomListener === void 0 ? void 0 : mouseMoveDomListener.dispose();
            mouseDownDownListener.dispose();
            mouseLeaveDomListener.dispose();
            tokenSource.dispose(true);
        });
    };
    const mouseOverDomEmitter = dom.addDisposableListener(htmlElement, dom.EventType.MOUSE_OVER, mouseEnter, true);
    return toDisposable(() => {
        mouseOverDomEmitter.dispose();
        hoverPreparation === null || hoverPreparation === void 0 ? void 0 : hoverPreparation.dispose();
        hoverWidget === null || hoverWidget === void 0 ? void 0 : hoverWidget.dispose();
    });
}
function getTooltipForCustom(markdownTooltip) {
    if (isString(markdownTooltip)) {
        return () => __awaiter(this, void 0, void 0, function* () { return markdownTooltip; });
    }
    else if (isFunction(markdownTooltip.markdown)) {
        return markdownTooltip.markdown;
    }
    else {
        const markdown = markdownTooltip.markdown;
        return () => __awaiter(this, void 0, void 0, function* () { return markdown; });
    }
}
